<?php

// app/Http/Controllers/Api/StaffController.php

namespace App\Http\Controllers\Api;

use App\Models\Staff;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;

class StaffController extends Controller
{
    public function index()
    {
        return StaffResource::collection(Staff::with(['user', 'deliveries', 'chats', 'calls'])->get());
    }

    public function store(StoreStaffRequest $request)
    {
        $staff = Staff::create($request->validated());
        return new StaffResource($staff->load(['user', 'deliveries', 'chats', 'calls']));
    }

    public function show(Staff $staff)
    {
        return new StaffResource($staff->load(['user', 'deliveries', 'chats', 'calls']));
    }

    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->validated());
        return new StaffResource($staff->load(['user', 'deliveries', 'chats', 'calls']));
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
