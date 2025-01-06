<?php

namespace App\Http\Controllers;

use App\Models\Social;
use App\Http\Resources\SocialResource;
use App\Http\Requests\StoreSocialRequest;
use App\Http\Requests\UpdateSocialRequest;
use App\traits\ApiResonse;

class SocialController extends Controller
{
    use ApiResonse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socials = Social::get();
        return $this->success(SocialResource::collection($socials));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Social $social)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialRequest $request, Social $social)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Social $social)
    {
        //
    }
}
