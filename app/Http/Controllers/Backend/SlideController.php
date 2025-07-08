<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Models\Slide;
use App\Services\SlideService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SlideController extends Controller
{
    protected $slideService;

    public function __construct(
        SlideService $slideService,
        )
    {
        $this->slideService = $slideService;
    }

    public function index(Request $request){
        Gate::authorize('modules', 'slide.index');
        $slides = $this->slideService->paginate($request);
        return view('Backend.slide.slide.index', compact('slides'));
    }

    public function create(){
        Gate::authorize('modules', 'slide.create');

        return view('Backend.slide.slide.create');
    }

    public function store(StoreSlideRequest $request){
        Gate::authorize('modules', 'slide.create');
        if($this->slideService->create($request)){
            return redirect()->route('slide.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.member')]));
        }

        return redirect()->route('slide.index')->with('error', __('alert.addError', ['attribute'=> __('custom.member')]));
    }

    public function edit(Slide $slide){
        Gate::authorize('modules', 'slide.update');
        return view('backend.slide.slide.create', compact('slide'));
    }

    public function update($id, UpdateSlideRequest $request){
        Gate::authorize('modules', 'slide.update');
        if($this->slideService->update($id, $request)){
            return redirect()->route('slide.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.member')]));
        }

        return redirect()->route('slide.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.member')]));
    }

    public function delete(Slide $slide){
        Gate::authorize('modules', 'slide.delete');
        return view('backend.slide.slide.delete', [
            'slide' => $slide
        ]);
    }

    public function destroy($id){
        Gate::authorize('modules', 'slide.delete');
        if($this->slideService->destroy($id)){
            return redirect()->route('slide.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.member')]));
        }

        return redirect()->route('slide.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.member')]));
    }

}
