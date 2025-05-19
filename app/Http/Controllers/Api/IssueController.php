<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Http\Resources\IssueResource;

class IssueController extends Controller
{
    public function index()
    {
        return IssueResource::collection(Issue::all());
    }

    public function store(StoreIssueRequest $request)
    {
        $issue = Issue::create($request->validated());
        return new IssueResource($issue);
    }

    public function show(Issue $issue)
    {
        return new IssueResource($issue);
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $issue->update($request->validated());
        return new IssueResource($issue);
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
