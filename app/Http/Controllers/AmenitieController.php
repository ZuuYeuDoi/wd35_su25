<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmenitieController extends Controller
{
    public function index()
    {
        return 1;
    }

    public function create()
    {
        return view('admin.bookingrooms.Amenities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'status' => 'required',
            'description' => 'nullable|string',
        ], [
            'image.required' => 'Vui lòng chọn ảnh tiện ích.',
            'image.image' => 'File phải là ảnh hợp lệ.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'name.required' => 'Vui lòng nhập tên tiện ích.',
            'name.string' => 'Tên tiện ích phải là chuỗi ký tự.',
            'name.max' => 'Tên tiện ích không được vượt quá 255 ký tự.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
        ]);

        try {
            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('amenities/images', 'public');
            }

            Amenitie::create([
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $path,
            ]);

            return redirect()->route('amenitie.index')->with('success', 'Thêm mới tiện ích thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm thất bại: ');
        }
    }

    public function edit($id)
    {
        try {
            $amenitie = Amenitie::findOrFail($id);
            return view('admin.bookingrooms.Amenities.edit', compact('amenitie'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không tìm thấy tiện ích này');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'status' => 'required',
            'description' => 'nullable|string',
        ], [
            'image.image' => 'File phải là ảnh hợp lệ.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'name.required' => 'Vui lòng nhập tên tiện ích.',
            'name.string' => 'Tên tiện ích phải là chuỗi ký tự.',
            'name.max' => 'Tên tiện ích không được vượt quá 255 ký tự.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
        ]);

        try {
            $amenitie = Amenitie::findOrFail($id);
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
            ];

            if ($request->hasFile('image')) {
                // Xóa ảnh cũ
                if ($amenitie->image) {
                    Storage::disk('public')->delete($amenitie->image);
                }
                // Upload ảnh mới
                $data['image'] = $request->file('image')->store('amenities/images', 'public');
            }

            $amenitie->update($data);
            return redirect()->route('amenitie.index')->with('success', 'Cập nhật tiện ích thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thất bại: ');
        }
    }
}
