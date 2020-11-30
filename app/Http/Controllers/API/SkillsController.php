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

        return response()->json(compact('skills'), 200);
    }

    /**
     * Return a skill's details
     *
     * @param Skill $skill
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Skill $skill) {
        return response()->json(['skill' => new SkillResource($skill)], 200);
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

        return response()->json(['skill' => new SkillResource($skill)], 201);
    }

    /**
     * Update a specific skill
     *
     * @param SkillsUpdateRequest $request
     * @param Skill         $skill
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SkillsUpdateRequest $request, Skill $skill) {
        $skill->update($request->only('title'));

        return response()->json(null, 204);
    }

    /**
     * Delete a specific user
     *
     * @param Skill $skill
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Skill $skill) {
        $skill->delete();

        return response()->json(null, 204);
    }
}
