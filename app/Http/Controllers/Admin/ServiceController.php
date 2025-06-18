<?php

namespace App\Http\Controllers\Admin;


use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|boolean',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là chuỗi.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'description.string' => 'Mô tả phải là chuỗi.',

            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được nhỏ hơn 0.',

            'unit.required' => 'Đơn vị tính là bắt buộc.',
            'unit.string' => 'Đơn vị tính phải là chuỗi.',
            'unit.max' => 'Đơn vị tính không được vượt quá 50 ký tự.',

            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.image' => 'Tệp phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg hoặc png.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('services', 'public');
            }

            Service::create($validated);

            return redirect()->route('services.index')->with('success', 'Thêm thành công Dịch Vụ mới!');
        } catch (\Exception $e) {
            // Nếu có ảnh vừa upload, xóa để tránh rác
            if (!empty($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm dịch vụ mới');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $service = Service::findOrFail($id);

            return view('admin.services.show', compact('service'));
        } catch (\Throwable $th) {
            return view('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $service = Service::findOrFail($id);

            return view('admin.services.edit', compact('service'));
        } catch (\Throwable $th) {
            return view('errors.404');  // Nếu không tìm thấy hoặc lỗi thì trả về trang lỗi 404
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập tên dịch vụ.',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'image.image' => 'File ảnh dịch vụ không hợp lệ.',
            'image.mimes' => 'Ảnh dịch vụ phải có định dạng jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh dịch vụ không được vượt quá 2MB.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá dịch vụ phải là số.',
            'price.min' => 'Giá dịch vụ không được nhỏ hơn 0.',
            'unit.required' => 'Vui lòng nhập đơn vị.',
            'unit.max' => 'Đơn vị không được vượt quá 50 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            $service = Service::findOrFail($id);

            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'unit' => $request->unit,
                'description' => $request->description,
                'status' => $request->status,
            ];

            // Xử lý upload ảnh mới nếu có
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu tồn tại
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $data['image'] = $request->file('image')->store('services/images', 'public');
            }

            $service->update($data);

            return redirect()->route('services.index')->with('success', 'Cập nhật dịch vụ thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật dịch vụ');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.index')->with('success', 'xóa Dịch vụ thành công!');
    }

    public function trash()
    {
        $services = Service::onlyTrashed()->paginate(10);
        return view('admin.services.trash', compact('services'));
    }

    public function restore($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->restore();

        return redirect()->route('services.trash')->with('success', 'Khôi phục dịch vụ thành công!');
    }

    public function forceDelete($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);

        // Xóa ảnh nếu có
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->forceDelete();

        return redirect()->route('services.trash')->with('success', 'Xóa vĩnh viễn dịch vụ thành công!');
    }
}
