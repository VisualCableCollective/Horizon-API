<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Store\Team;

class TeamController extends Controller
{

    /**
     * Display the specified team.
     *
     * @param int $id ID of the team
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Team::findorfail($id);
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
