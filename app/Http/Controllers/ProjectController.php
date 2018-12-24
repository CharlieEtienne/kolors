<?php

namespace App\Http\Controllers;
use App\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has(['Elem', 'Type', 'NewValue'])) {
            $project = new Project;

            $project->{$request->Elem} = $request->NewValue;
            $project->user_id = auth()->user()->id;
            $project->save();
            $id = $project->id;
            return response()->json([
                'success' => 'Project successfully created!', 
                'id' => $id,
                'action' => 'create',
                'type' => 'project'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has(['Elem', 'Type', 'Id', 'NewValue'])) {
            $project = Project::findOrFail($request->Id);
            if ($project) {
                $project->{$request->Elem} = $request->NewValue;
                $project->save();
                return response()->json([
                    'success' => 'Project successfully updated!', 
                    'id' => $id,
                    'action' => 'update',
                    'type' => 'project'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::destroy($id);
        return response()->json(['success' => 'Project deleted!', 'id' => $id]);
    }
}
