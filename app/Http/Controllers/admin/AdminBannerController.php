<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminBannerController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'id'); // Mặc định sắp xếp theo ID
        $sortOrder = $request->input('sort_order', 'asc'); // Mặc định tăng dần
        $search = $request->input('search'); // Lấy giá trị tìm kiếm

        $query = Banner::query()->whereNull('deleted_at');

        // Nếu có từ khóa tìm kiếm, thực hiện lọc theo tiêu đề
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Kiểm tra xem $sortBy có nằm trong danh sách các cột được phép sắp xếp hay không
        if (in_array($sortBy, ['id', 'title'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Nếu không hợp lệ, sắp xếp theo ID mặc định
            $query->orderBy('id', $sortOrder);
            $sortBy = 'id'; // Cập nhật lại giá trị $sortBy cho view
        }

        $banners = $query->paginate(10)->appends($request->query());

        return view('admin.banner.index', compact('banners', 'sortBy', 'sortOrder', 'search'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'description' => 'nullable|string',
            'type' => 'required|string|in:slider,top,middle,bottom',
            'status' => 'required|boolean',
        ]);
        // dd($request->file('image')->getMimeType());


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Kiểm tra xem type của ảnh là top có đủ 4 ảnh chưa nếu đủ thì không cho tạo nữa
        if ($request->type == 'top') {
            $count = Banner::where('type', 'top')->count();
            if ($count >= 4) {
                return redirect()->back()->with('error', 'Đã đủ 4 banner loại top! Hãy xóa ảnh trước đó!');
            }
        }
        // Kiểm tra xem type của ảnh là bottom có đủ 1 ảnh chưa nếu đủ thì không cho tạo nữa
        if ($request->type == 'bottom') {
            $count = Banner::where('type', 'bottom')->count();
            if ($count >= 1) {
                return redirect()->back()->with('error', 'Đã đủ 1 banner loại bottom!Hãy xóa ảnh trước đó!');
            }
        }

        // Upload ảnh
        $imagePath = $request->file('image')->store('banners', 'public');

        // Lưu vào database
        $Banner = Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        // Ghi log
        LogHelper::logAction('Tạo banner mới có ID: ' . $Banner->id);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:slider,top,middle,bottom',
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
        // Ghi log
        LogHelper::logAction('Cập nhật banner có ID: ' . $banner->id);

        return redirect()->back()->with('success', 'Banner đã được cập nhật!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete(); // Soft delete
        LogHelper::logAction('Đưa banner có ID: ' . $banner->id . ' vào thùng rác');
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được đưa vào thùng rác!');
    }
    public function trash()
    {
        $banners = Banner::onlyTrashed()->paginate(10);
        return view('admin.banner.trash', compact('banners'));
    }

    public function restore($id)
    {
        Banner::withTrashed()->findOrFail($id)->restore();
        LogHelper::logAction('Khôi phục banner có ID: ' . $id . ' từ thùng rác');
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được khôi phục!');
    }

    public function delete($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->forceDelete();
        LogHelper::logAction('Xóa vĩnh viễn banner có ID: ' . $id . ' khỏi thùng rác');
        return redirect()->route('admin.banners.trash')->with('success', 'Banner đã bị xóa vĩnh viễn!');
    }
}
