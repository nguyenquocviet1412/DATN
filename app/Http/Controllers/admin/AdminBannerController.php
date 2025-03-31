<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::whereNull('deleted_at')->paginate(10);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'type' => 'required|string|in:slider,advertisement',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload ảnh
        $imagePath = $request->file('image')->store('banners', 'public');

        // Lưu vào database
        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được tạo!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:slider,advertisement',
            'status' => 'required|boolean'
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Ảnh không được lớn hơn 4MB.',

            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',

            'type.required' => 'Vui lòng chọn loại banner.',
            'type.in' => 'Loại banner không hợp lệ.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        // Tìm banner
        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->type = $request->type;
        $banner->status = $request->status;

        // Cập nhật ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = $imagePath;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete(); // Chuyển vào thùng rác nếu dùng soft delete

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa!');
    }
    public function trash()
    {
        $banners = Banner::whereNotNull('deleted_at')->paginate(10);
        return view('admin.banner.trash', compact('banners'));
    }

    public function restore($id)
    {
        Banner::where('id', $id)->update(['deleted_at' => null]);
        return redirect()->route('admin.banners.trash')->with('success', 'Banner đã được khôi phục!');
    }

    public function delete($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        Storage::disk('public')->delete($banner->image);
        $banner->forceDelete();
        return redirect()->route('admin.banners.trash')->with('success', 'Banner đã bị xóa vĩnh viễn!');
    }
}
