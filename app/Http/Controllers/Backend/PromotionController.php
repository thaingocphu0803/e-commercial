<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Services\PromotionService;
use App\Services\AttrCatalougeService;
use App\Services\SourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $attrCatalougeService;
    protected $sourceService;


    public function __construct(
        PromotionService $promotionService,
        AttrCatalougeService $attrCatalougeService,
        SourceService $sourceService
    ) {
        $this->promotionService = $promotionService;
        $this->attrCatalougeService = $attrCatalougeService;
        $this->sourceService = $sourceService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'promotion.index');
        $promotions = $this->promotionService->paginate($request);
        return view('backend.promotion.promotion.index', [
            'promotions' => $promotions,
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'promotion.create');
        $sources = $this->sourceService->getAll();

        return view('backend.promotion.promotion.create', [
            'sources' => $sources,
        ]);
    }

    public function store(StorePromotionRequest $request)
    {
        Gate::authorize('modules', 'promotion.create');
        if ($this->promotionService->create($request)) {
            return redirect()->route('promotion.index')->with('success',  __('alert.addSuccess', ['attribute'=> __('custom.promotion')]));
        }
        return redirect()->route('promotion.index')->with('error',  __('alert.addError', ['attribute'=> __('custom.promotion')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'promotion.update');
        $promotion = $this->promotionService->findById($id);
        $sources = $this->sourceService->getAll();

        return view('backend.promotion.promotion.create', [
            'promotion' => $promotion,
            'sources' => $sources

        ]);
    }

    public function update($id, UpdatePromotionRequest $request)
    {
        Gate::authorize('modules', 'promotion.update');
        if ($this->promotionService->update($id, $request)) {
            return redirect()->route('promotion.index')->with('success',  __('alert.updateSuccess', ['attribute'=> __('custom.promotion')]));
        }

        return redirect()->route('promotion.index')->with('error',  __('alert.updateError', ['attribute'=> __('custom.promotion')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'promotion.delete');
        $promotion = $this->promotionService->findById($id);

        return view('backend.promotion.promotion.delete', [
            'promotion' => $promotion
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'promotion.delete');
        if ($this->promotionService->destroy($id)) {
            return redirect()->route('promotion.index')->with('success',  __('alert.deleteSuccess', ['attribute'=> __('custom.promotion')]));
        }

        return redirect()->route('promotion.index')->with('error',  __('alert.deleteError', ['attribute'=> __('custom.promotion')]));
    }
}
