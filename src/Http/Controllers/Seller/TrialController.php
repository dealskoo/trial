<?php

namespace Dealskoo\Trial\Http\Controllers\Seller;

use Carbon\Carbon;
use Dealskoo\Product\Models\Product;
use Dealskoo\Seller\Http\Controllers\Controller as SellerController;
use Dealskoo\Trial\Models\Trial;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TrialController extends SellerController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('trial::seller.trial.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'title', 'refund', 'quantity', 'ship_fee', 'clicks', 'product_id', 'category_id', 'country_id', 'brand_id', 'platform_id', 'approved_at', 'start_at', 'end_at', 'created_at', 'updated_at'];
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
        foreach ($trials as $trial) {
            $row = [];
            $row[] = $trial->id;
            $row[] = $trial->title . ' <span class="badge bg-success">' . $trial->off . '% Off</span>';
            $row[] = $trial->country->currency_symbol . $trial->price . ' <del>' . $trial->country->currency_symbol . $trial->product->price . '</del>';
            $row[] = $trial->country->currency_symbol . $trial->ship_fee;
            $row[] = $trial->clicks;
            $row[] = $trial->code;
            $row[] = $trial->product->name;
            $row[] = $trial->category->name;
            $row[] = $trial->country->name;
            $row[] = $trial->brand ? $trial->brand->name : '';
            $row[] = $trial->platform ? $trial->platform->name : '';
            $row[] = $trial->approved_at != null ? Carbon::parse($trial->approved_at)->format('Y-m-d H:i:s') : null;
            $row[] = $trial->start_at != null ? Carbon::parse($trial->start_at)->format('Y-m-d') : null;
            $row[] = $trial->end_at != null ? Carbon::parse($trial->end_at)->format('Y-m-d') : null;
            $row[] = Carbon::parse($trial->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($trial->updated_at)->format('Y-m-d H:i:s');
            $edit_link = '';
            $destroy_link = '';
            if ($trial->approved_at == null) {
                $edit_link = '<a href="' . route('seller.trials.edit', $trial) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="trials_table" data-url="' . route('seller.trials.destroy', $trial) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function create(Request $request)
    {
        $products = Product::approved()->where('seller_id', $request->user()->id)->get();
        return view('trial::seller.trial.create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'product_id' => ['required', 'exists:products,id'],
            'refund' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'ship_fee' => ['required', 'numeric'],
            'activity_date' => ['required', 'string']
        ]);
        $between = explode(' - ', $request->input('activity_date'));
        $start = date('Y-m-d', strtotime($between[0]));
        $end = date('Y-m-d', strtotime($between[1]));
        $product = Product::approved()->where('seller_id', $request->user()->id)->findOrFail($request->input('product_id'));
        $trial = new Trial(Arr::collapse([$request->only([
            'title', 'product_id', 'refund', 'quantity', 'ship_fee'
        ]), $product->only([
            'seller_id', 'category_id', 'country_id', 'brand_id', 'platform_id'
        ]), ['start_at' => $start, 'end_at' => $end]]));
        $trial->save();
        return redirect(route('seller.trials.index'));
    }

    public function edit(Request $request, $id)
    {
        $trial = Trial::where('seller_id', $request->user()->id)->findOrFail($id);
        $products = Product::approved()->where('seller_id', $request->user()->id)->get();
        return view('trial::seller.trial.edit', ['trial' => $trial, 'products' => $products]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'product_id' => ['required', 'exists:products,id'],
            'refund' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'ship_fee' => ['required', 'numeric'],
            'activity_date' => ['required', 'string']
        ]);
        $between = explode(' - ', $request->input('activity_date'));
        $start = date('Y-m-d', strtotime($between[0]));
        $end = date('Y-m-d', strtotime($between[1]));
        $product = Product::approved()->where('seller_id', $request->user()->id)->findOrFail($request->input('product_id'));
        $trial = Trial::where('seller_id', $request->user()->id)->findOrFail($id);
        $trial->fill(Arr::collapse([$request->only([
            'title', 'product_id', 'refund', 'quantity', 'ship_fee'
        ]), $product->only([
            'seller_id', 'category_id', 'country_id', 'brand_id', 'platform_id'
        ]), ['start_at' => $start, 'end_at' => $end]]));
        $trial->save();
        return redirect(route('seller.trials.index'));
    }

    public function destroy(Request $request, $id)
    {
        return ['status' => Trial::where('seller_id', $request->user()->id)->where('approved_at', null)->where('id', $id)->delete()];
    }
}
