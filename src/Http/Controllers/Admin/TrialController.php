<?php

namespace Dealskoo\Trial\Http\Controllers\Admin;

use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Admin\Rules\Slug;
use Dealskoo\Trial\Models\Trial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrialController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('trials.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('trial::admin.trial.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'title', 'refund', 'quantity', 'ship_fee', 'clicks', 'seller_id', 'product_id', 'category_id', 'country_id', 'brand_id', 'platform_id', 'approved_at', 'start_at', 'end_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Trial::query();
        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $trials = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('trials.show');
        $can_edit = $request->user()->canDo('trials.edit');
        foreach ($trials as $trial) {
            $row = [];
            $row[] = $trial->id;
            $row[] = Str::words($trial->title, 5, '...') . ' <span class="badge bg-success">' . __(':refund% Refund', ['refund' => $trial->refund_rate]) . '</span>';
            $row[] = $trial->country->currency_symbol . $trial->refund . ' <del>' . $trial->country->currency_symbol . $trial->product->price . '</del>';
            $row[] = $trial->quantity;
            $row[] = $trial->country->currency_symbol . $trial->ship_fee;
            $row[] = $trial->clicks;
            $row[] = $trial->seller->name;
            $row[] = $trial->product->name;
            $row[] = $trial->category->name;
            $row[] = $trial->country->name;
            $row[] = $trial->brand ? $trial->brand->name : '';
            $row[] = $trial->platform ? $trial->platform->name : '';
            $row[] = $trial->approved_at != null ? $trial->approved_at->format('Y-m-d H:i:s') : null;
            $row[] = $trial->start_at != null ? $trial->start_at->format('Y-m-d') : null;
            $row[] = $trial->end_at != null ? $trial->end_at->format('Y-m-d') : null;
            $row[] = $trial->created_at->format('Y-m-d H:i:s');
            $row[] = $trial->updated_at->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.trials.show', $trial) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.trials.edit', $trial) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $row[] = $view_link . $edit_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('trials.show'), 403);
        $trial = Trial::query()->findOrFail($id);
        return view('trial::admin.trial.show', ['trial' => $trial]);
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('trials.edit'), 403);
        $trial = Trial::query()->findOrFail($id);
        return view('trial::admin.trial.edit', ['trial' => $trial]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('trials.edit'), 403);
        $request->validate([
            'slug' => ['required', new Slug('trials', 'slug', $id, 'id')]
        ]);
        $trial = Trial::query()->findOrFail($id);
        $trial->fill($request->only([
            'slug'
        ]));
        $trial->approved_at = $request->boolean('approved', false) ? now() : null;
        $trial->save();
        return back()->with('success', __('admin::admin.update_success'));
    }
}
