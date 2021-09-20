<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithRelationshipsRequest;
use App\Models\Store\Team;
use Illuminate\Database\Eloquent\Builder;

class TeamController extends Controller
{
    /**
     * Display the specified team.
     *
     * @param int $id ID of the team
     * @return \Illuminate\Http\Response
     */
    public function show(WithRelationshipsRequest $request, int $id)
    {
        $withRelationships = $request->getRequestedRelationships(['products']);

        return Team::with($withRelationships)->findorfail($id);
    }
    /**
     * Display the products of the team.
     *
     * @param int $id ID of the team
     * @return \Illuminate\Http\Response
     */
    public function products(int $id) {
        return Team::findorfail($id)->products()->get();
    }
}
