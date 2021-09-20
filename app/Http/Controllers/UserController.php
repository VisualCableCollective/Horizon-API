<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithRelationshipsRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Returns data for the authenticated suer
     */
    public function show_authenticated(WithRelationshipsRequest $request) {
        $withRelationships = $request->getRequestedRelationships(['teams']);
        return User::with($withRelationships)->findorfail($request->user()->id);
    }
}
