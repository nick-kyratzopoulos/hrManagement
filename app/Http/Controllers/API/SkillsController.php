<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skill\SkillsStoreRequest;
use App\Http\Requests\Skill\SkillsUpdateRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Get a list of skills
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $skills = SkillResource::collection(Skill::all());
        $count = count($skills);

        return response()->json(compact('skills', 'count'), 200);
    }

    /**
     * Create a new skill
     *
     * @param SkillsStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SkillsStoreRequest $request) {
        $skill = Skill::create($request->only('title'));

        if ($skill) {
            return response()->json(compact('skill'), 200);
        }
        
        return response()->json('Skill not created!', 404);
    }

    /**
     * Get a single skill
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $skill = Skill::find($id);

            if ($skill) {
                return response()->json(compact('skill'), 200);
            }
        }

        return response()->json('Skill not found!', 404);
    }

    /**
     * Update a specific skill
     *
     * @param SkillsUpdateRequest $request
     * @param int                $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SkillsUpdateRequest $request, $id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $skill = Skill::find($id);

            if ($skill) {
                $skill->update($request->only('title'));

                return response()->json(compact('skill'), 200);
            }
        }

        return response()->json('Skill not found, unable to be updated!', 404);
    }

    /**
     * Delete a specific skill
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $skill = Skill::find($id);

            if ($skill) {
                $skill->delete();
            
                return response()->json('Skill deleted!', 200);
            }
        }
        
        return response()->json('Skill not found, unable to be deleted!', 404);
    }
}
