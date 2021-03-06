<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ServerGroup;
use Encore\Admin\Form;
use Encore\Admin\Form\Builder;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use PluginManager;

class ProductController extends Controller
{
    protected $title = 'Products';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->filter(function ($filter) {
            // 在这里添加字段过滤器
            $filter->like('name', __('Name'));
            $filter->in('product_group_id', __('Product group'))->multipleSelect('/admin/api/products');
            $filter->in('type', __('Type'))->multipleSelect(__('service.type'));
            $filter->equal('hide', __('Hide'))->radio([
                '' => '不限',
                1 => '是',
                0 => '否',
            ]);
            $filter->equal('enable', __('Enable'))->radio([
                '' => '不限',
                1 => '是',
                0 => '否',
            ]);
            $filter->between('created_at', __('Created at'))->datetime();
            $filter->between('updated_at', __('Updated at'))->datetime();
        });

        $grid->column('group.name', __('Product group'));
        $grid->column('name', __('Name'))->sortable();
        $grid->column('type', __('Type'))->using(__('service.type'))->sortable();
        $grid->column('hide', __('Hide'))->sortable()->switch();
        $grid->column('enable', __('Enable'))->sortable()->switch();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('group.name', __('Product group'));
        $show->field('name', __('Name'));
        $show->field('type', __('Type'))->using(__('service.type'));
        $show->field('description', __('Description'))->unescape()->as(function () {
            return $this->getCleanDescription();
        });
        $show->field('hide', __('Hide'))->using(usingList());
        $show->field('enable', __('Enable'))->using(usingList());
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->services(__('Services'), function ($service) {

            $service->resource('/admin/service');

            $service->id('ID');
            $service->user(__('User'))->display(function ($user) {
                return '<a href="' . route('admin.user.show', $user['id']) . '">' . $user['username'] . '</a>';
            });
            $service->name();
            $service->username();
            $service->domain();
            $service->status()->display(function () {
                return $this->status_text;
            })->label([
                'active' => 'success',
                'suspended' => 'warning',
                'pending' => 'info',
                'terminated' => 'danger',
                'cancelled' => 'default'
            ]);
            $service->expire_at();
            $service->created_at();

            $service->actions(function ($actions) {
                // 去掉查看
                $actions->disableView();
            });

        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->hidden('tab_index');
        $form->ignore(['tab_index']);
        $tab_index = request()->get('tab');
        $form->html(<<<HTML
<script>
$(function() {
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        $("input[name='tab_index']").val($(e.target).attr("href").substring(10))
    });
    $(document).ready(function() {
        $("input[name='tab_index']").val('$tab_index')
    })
})
</script>
HTML
        );

        $form->tab(__('admin.product.tab.base'), function (Form $form) {
            $form->text('name', __('Name'))->required();
            $form->select('type', __('Type'))->options(__('service.type'))->required();
            $form->select('group_id', __('Product group'))->required()
                ->options(ProductGroup::all()->pluck('name', 'id'));
            $form->textarea('description', __('Description'))->rows(10)
                ->style('resize', 'vertical')->help(__('admin.help.product.description'));
            $form->switch('require_domain', __('admin.product.domain.require'))
                ->help(__('admin.help.product.require_domain'));
            $form->switch('ena_stock', __('admin.product.ena_stock'))
                ->help(__('admin.help.product.ena_stock'));
            $form->number('stocks', __('Stocks'))->default(0);
            $form->number('order', __('admin.sort_order'))->default(0);
            $form->switch('hide', __('Hide'));
            $form->switch('enable', __('Enable'))->default(1);
        }, request('tab') == 1)->tab(__('admin.product.tab.price'), function (Form $form) {
            $form->price('price');
            $form->embeds('price_configs', '', function (Form\EmbeddedForm $form) {
                $form->switch('unlimited_when_buy', __('admin.product.price.unlimited_when_buy'))
                    ->help(__('admin.help.product.unlimited_when_buy'));
                $form->number('free_limit_days', __('admin.product.price.free_limit_days'))
                    ->help(__('admin.help.product.free_limit_days'))->default(0);
                $form->number('free_limit', __('admin.product.price.free_limit'))
                    ->help(__('admin.help.product.free_limit'))->default(0);
            });
        }, request('tab') == 2)->tab(__('admin.product.tab.api'), function (Form $form) {
            foreach (PluginManager::getServerPluginList() as $slug => $plugin) {
                $plugins[$plugin] = PluginManager::getPluginInfo($slug)['name'] ?? $plugin;
            }
            $form->select('server_plugin', __('admin.product.server.plugin'))->options($plugins ?? [])
                ->load('server_group_id', '/admin/api/server_groups');
            $form->select('server_group_id', __('admin.product.server.group'))
                ->options(function ($id) {
                    $sp = $this->server_plugin;
                    return ServerGroup::whereExists(function ($query) use ($sp) {
                        $query->from('servers')->where('server_plugin', $sp)
                            ->whereRaw("JSON_CONTAINS(server_groups.servers,concat('[\"',servers.id,'\"]'))");
                    })->get()->pluck('name', 'id');
                });
            $parent = $form;
            $form->embeds('server_configs', __('Settings'), function ($form) use ($parent) {
                $plugin = $parent->model()->server_plugin;
                if (class_exists($plugin)) {
                    $configs = $plugin::productConfig();
                    buildFormFromArr($configs, $form);
                }
            });
        }, request('tab') == 3)->tab(__('Upgrade') . '/' . __('Downgrade'), function (Form $form) {
            $form->embeds('upgrade_downgrade_config', '', function (Form\EmbeddedForm $form) {
                $form->switch('enable', __('admin.product.enable_udg'));
            });
        }, request('tab') == 4)->tab(__('Domain'), function (Form $form) {
            $form->embeds('domain_configs', '', function (Form\EmbeddedForm $form) {
                $form->tags('free_domain', __('admin.product.domain.free'))
                    ->help(__('admin.help.product.free_domain'));
            });
        }, request('tab') == 5)->tab(__('Others'), function (Form $form) {

        }, request('tab') == 6);

        $form->footer(function (Form\Footer $footer) {
            // 默认勾选`继续编辑`
            $footer->checkEditing();
        });

        $form->saving(function (Form $form) {
            if (request()->pjax()) {
                $price_table = [];
                foreach ((array)$form->price as $id => $price) {
                    if (empty($price['name'])) continue;
                    $price_table[$id] = [
                        'name' => $price['name'],
                        'period' => $price['period'],
                        'period_unit' => $price['period_unit'],
                        'price' => $price['price'],
                        'setup' => $price['setup'],
                        'enable' => isset($price['enable']),
                        'auto_activate' => isset($price['auto_activate']),
                        'allow_renew' => isset($price['allow_renew'])
                    ];
                }
                $form->price = $price_table;
            }
        });

        $form->saved(function (Form $form) {
            if (request()->ajax() && !request()->pjax()) {
                return response()->json([
                    'status' => true,
                    'message' => trans('admin.update_succeeded'),
                ]);
            }

            $resourcesPath = route('admin.product.index');

            if (request('after-save') == 1) {
                // continue editing
                $url = rtrim($resourcesPath, '/') . "/{$form->model()->id}/edit?tab=" . request('tab_index');
            } elseif (request('after-save') == 2) {
                // continue creating
                $url = rtrim($resourcesPath, '/') . '/create';
            } elseif (request('after-save') == 3) {
                // view resource
                $url = rtrim($resourcesPath, '/') . "/{$form->model()->id}";
            } else {
                $url = request(Builder::PREVIOUS_URL_KEY) ?: $resourcesPath;
            }

            admin_toastr(trans('admin.update_succeeded'));

            return redirect($url);
        });

        return $form;
    }
}
