<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminController extends Controller
{
    // =========================================================
    // 1. หน้า Dashboard และการโหลดข้อมูลตาม View
    // =========================================================
    public function index(Request $request)
    {
        $viewType = $request->query('view', 'dashboard');
        
        // สถิติภาพรวม (แสดงทุกหน้า)
        $stats = [
            'pending_q' => DB::table('quotations')->where('status', 'pending')->count(),
            'unread_msg' => DB::table('contact_messages')->where('status', 'unread')->count(),
            'pending_pay' => DB::table('payments')->where('status', 'pending')->count(),
            'total_prod' => DB::table('products')->count(),
            'total_gallery' => DB::table('galleries')->count(),
        ];

        $data = [
            'viewType' => $viewType, 
            'stats' => $stats,
            'products' => DB::table('products')->orderBy('id', 'asc')->get(),
            'galleries' => DB::table('galleries')->orderBy('sort_order', 'asc')->get(),
            'productParts' => collect(), 
            'quotations' => collect(),
            'contacts' => collect(),
            'payments' => collect(),
            'activities' => collect(),
            'sizes' => collect(),
            'printings' => collect(),
            'prices' => collect(),
            'quantities' => collect(),
            'faqs' => collect()
        ];

        // โหลดข้อมูลเฉพาะส่วนตาม View ที่เลือก เพื่อลดภาระ Server
        if ($viewType == 'quotations') {
            $data['quotations'] = DB::table('quotations')
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString(); 

        } elseif ($viewType == 'contacts') {
            $data['contacts'] = DB::table('contact_messages')
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString();

        } elseif ($viewType == 'payments') {
            $data['payments'] = DB::table('payments')->orderBy('created_at', 'desc')->get();

        } elseif ($viewType == 'addons') {
            $data['productParts'] = DB::table('product_parts')->get();

        } elseif ($viewType == 'faq') {
            $data['faqs'] = DB::table('faq_details')->orderBy('id', 'asc')->get();

        } elseif ($viewType == 'products') {
            // โหลดข้อมูลสำหรับหน้าจัดการสินค้า/ราคา
            $data['sizes'] = DB::table('product_sizes')->orderBy('id', 'asc')->get();
            $data['printings'] = DB::table('product_printings')->orderBy('id', 'asc')->get();
            $data['prices'] = DB::table('product_price')->get();
            
            // ดึงจำนวนขั้นต่ำที่มีการตั้งราคาไว้ (เพื่อทำหัวตาราง)
            $data['quantities'] = DB::table('product_price')
                ->where('price_per_unit', '>', 0)
                ->distinct()
                ->pluck('quantity_min')
                ->sort()
                ->values();

        } elseif ($viewType == 'dashboard') {
            // ข้อมูลกิจกรรมล่าสุด
            $data['activities'] = DB::table('quotations')
                ->select('fullname as user', 'created_at', DB::raw("'ขอใบเสนอราคา' as type"), DB::raw("'bi-file-earmark-text-fill' as icon"), 'quotation_number as ref')
                ->union(
                    DB::table('payments')
                    ->select('name as user', 'created_at', DB::raw("'แจ้งชำระเงิน' as type"), DB::raw("'bi-cash-stack' as icon"), 'order_id as ref')
                )
                ->orderBy('created_at', 'desc')->limit(10)->get();

            // ข้อมูลสำหรับกราฟ (ย้อนหลัง 7 วัน)
            $data['quotations'] = DB::table('quotations')
                ->where('created_at', '>=', Carbon::today()->subDays(7))
                ->get();
            $data['contacts'] = DB::table('contact_messages')
                ->where('created_at', '>=', Carbon::today()->subDays(7))
                ->get();
        }

        return view('admin.dashboard', $data);
    }

    // =========================================================
    // 2. ดูรายละเอียดใบเสนอราคา (Webview)
    // =========================================================
    public function viewQuotation($number)
    {
        $quotation = DB::table('quotations')->where('quotation_number', $number)->first();

        if (!$quotation) {
            abort(404, 'ไม่พบข้อมูลใบเสนอราคานี้ในระบบ');
        }

        $items = DB::table('quotation_items')
                ->where('quotation_id', $quotation->id)
                ->get();

        return view('admin.quotation_webview', compact('quotation', 'items'));
    }

    // =========================================================
    // 3. Export Quotation (PDF) - Mockup
    // =========================================================
    public function exportQuotation($number)
    {
        $quotation = DB::table('quotations')->where('quotation_number', $number)->first();
        if (!$quotation) return response()->json(['error' => 'Not Found'], 404);

        return response()->json([
            'quotation_number' => $number,
            'export_path' => asset('storage/exports/quotation_'.$number.'.pdf'), // ต้องไปทำ Logic สร้าง PDF จริง
            'status' => 'ready'
        ]);
    }

    // =========================================================
    // 4. API Center สำหรับรับค่า Ajax (Update All Data)
    // =========================================================
    public function updateData(Request $request)
    {
        try {
            // ------------------------------------------
            // 📦 Product: อัปเดตข้อมูลทั่วไป
            // ------------------------------------------
            if ($request->type == 'product_update') {
                DB::table('products')->where('id', $request->id)->update([
                    'name' => $request->name, 
                    'base_material' => $request->base_material, 
                    'updated_at' => now()
                ]);
            } 

            // ------------------------------------------
            // 📝 Product: อัปเดตรายละเอียดเชิงลึก (หน้าบ้าน)
            // ------------------------------------------
            elseif ($request->type == 'product_details_update') {
                DB::table('products')->where('id', $request->id)->update([
                    'moq' => $request->moq,
                    'packing' => $request->packing,
                    'production_time' => $request->production_time,
                    'free_sample_text' => $request->free_sample_text,
                    'special_features' => $request->special_features,
                    'custom_fields' => $request->custom_fields, // JSON
                    'updated_at' => now()
                ]);
            }

            // ------------------------------------------
            // 💰 Price Table: สร้างตารางราคาใหม่ (Rebuild)
            // ------------------------------------------
            elseif ($request->type == 'rebuild_price_table') {
                $productId = $request->product_id;
                $allData = $request->data; 

                DB::transaction(function () use ($productId, $allData, $request) {
                    // อัปเดต custom_fields ถ้าส่งมาด้วย
                    if($request->has('custom_fields')) {
                        DB::table('products')->where('id', $productId)->update([
                            'custom_fields' => $request->custom_fields
                        ]);
                    }

                    // ลบราคาและขนาดเก่าทิ้ง (เพื่อสร้างใหม่ตามที่ส่งมา)
                    DB::table('product_price')->where('product_id', $productId)->delete();
                    DB::table('product_sizes')->where('product_id', $productId)->delete();

                    if (!empty($allData) && is_array($allData)) {
                        foreach ($allData as $pane) {
                            $sizes = $pane['sizes'] ?? []; 
                            $grid = $pane['grid'] ?? [];
                            $printingId = $pane['printing_id'];

                            $note = $pane['note'] ?? ''; // รับค่าที่ส่งมา
                            DB::table('product_printings')->where('id', $printingId)->update([
                                'note' => $note,
                                'updated_at' => now()
                            ]);

                            // 1. สร้างขนาดใหม่
                            if (!empty($sizes)) {
                                $sizeIds = [];
                                foreach ($sizes as $sizeName) {
                                    $sizeIds[] = DB::table('product_sizes')->insertGetId([
                                        'product_id' => $productId,
                                        'size_name' => $sizeName,
                                        'width_mm' => 0, 'height_mm' => 0,
                                        'created_at' => now(), 'updated_at' => now()
                                    ]);
                                }

                                // 2. วนลูปสร้างราคาตาม Grid
                                if (!empty($grid)) {
                                    foreach ($grid as $row) {
                                        $qtyMin = (int)($row['quantity'] ?? 0); 
                                        foreach ($row['prices'] as $index => $unitPrice) {
                                            if (isset($sizeIds[$index])) {
                                                DB::table('product_price')->insert([
                                                    'product_id' => $productId,
                                                    'product_printing_id' => $printingId,
                                                    'product_size_id' => $sizeIds[$index],
                                                    'quantity_min' => $qtyMin,
                                                    'quantity_max' => $qtyMin, 
                                                    'price_per_unit' => (float)$unitPrice, 
                                                    'created_at' => now(),
                                                    'updated_at' => now()
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
                return response()->json(['status' => 'success']);
            }
            
            // ------------------------------------------
            // 🖨️ Printing: เทคนิคการพิมพ์
            // ------------------------------------------
            elseif ($request->type == 'printing_add') {
                DB::table('product_printings')->insert([
                    'product_id' => $request->product_id,
                    'printing_type' => $request->printing_name ?? 'เทคนิคใหม่',
                    'color_type' => '',
                    'note' => '', // Default empty note
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            elseif ($request->type == 'printing_name_update') {
                DB::table('product_printings')->where('id', $request->id)->update([
                    'printing_type' => $request->name,
                    'updated_at' => now()
                ]);
            }

            // ✅✅✅ ส่วนที่เพิ่มเข้ามาใหม่: อัปเดต Note (หมายเหตุ) ของเทคนิค ✅✅✅
            elseif ($request->type == 'printing_note_update') {
                DB::table('product_printings')->where('id', $request->id)->update([
                    'note' => $request->note,
                    'updated_at' => now()
                ]);
            }

            elseif ($request->type == 'printing_delete') {
                // ลบข้อมูลราคาที่เกี่ยวข้องก่อน
                DB::table('product_price')->where('product_printing_id', $request->id)->delete();
                // ลบเทคนิค
                DB::table('product_printings')->where('id', $request->id)->delete();
            }

            // ------------------------------------------
            // 🔛 Status: เปิด/ปิด สินค้า
            // ------------------------------------------
            elseif ($request->type == 'product_status_toggle') {
                DB::table('products')->where('id', $request->id)->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
                return response()->json(['status' => 'success']);
            }

            // ------------------------------------------
            // 🖼️ Images: รูปภาพสินค้า (หลัก/รอง)
            // ------------------------------------------
            elseif ($request->type == 'product_images_sort') {
                foreach ($request->order as $item) {
                    DB::table('product_images')->where('id', $item['id'])->update([
                        'sort_order' => $item['sort_order'],
                        'updated_at' => now()
                    ]);
                }
                return response()->json(['status' => 'success']);
            }
            
            elseif ($request->type == 'product_image_update') {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    // Path: public/images/Hotmobilyfile/product_images
                    $file->move(public_path('images/Hotmobilyfile/product_images'), $filename);
                    $newPath = 'images/Hotmobilyfile/product_images/' . $filename;

                    DB::table('product_images')->where('id', $request->image_id)->update([
                        'image_url' => $newPath,
                        'updated_at' => now()
                    ]);
                    return response()->json(['status' => 'success', 'path' => asset($newPath)]);
                }
            }

            // ------------------------------------------
            // ❓ FAQ: จัดการคำถามที่พบบ่อย
            // ------------------------------------------
            elseif ($request->type == 'faq_add') {
                DB::table('faq_details')->insert([
                    'question' => 'ระบุหัวข้อคำถามใหม่ที่นี่',
                    'answer' => 'ระบุคำตอบที่นี่',
                    'status' => 0, 
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return response()->json(['status' => 'success']);
            }

            elseif ($request->type == 'faq_update') {
                DB::table('faq_details')->where('id', $request->id)->update([
                    'question' => $request->question,
                    'answer' => $request->answer,
                    'updated_at' => now()
                ]);
                return response()->json(['status' => 'success']);
            }

            elseif ($request->type == 'faq_status_toggle') {
                DB::table('faq_details')->where('id', $request->id)->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
                return response()->json(['status' => 'success']);
            }

            elseif ($request->type == 'faq_delete') {
                DB::table('faq_details')->where('id', $request->id)->delete();
                return response()->json(['status' => 'success']);
            }

            elseif ($request->type == 'faq_image_update') {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = 'faq_' . time() . '_' . $file->getClientOriginalName();
                    // Path: public/images/Hotmobilyfile/faq
                    $file->move(public_path('images/Hotmobilyfile/faq'), $filename);
                    $path = 'images/Hotmobilyfile/faq/' . $filename;

                    $col = ($request->slot == 1) ? 'faq_image_1' : 'faq_image_2';
                    DB::table('faq_details')->where('id', $request->faq_id)->update([
                        $col => $path,
                        'updated_at' => now()
                    ]);

                    return response()->json(['status' => 'success', 'path' => asset($path)]);
                }
            }
            
            elseif ($request->type == 'faq_image_delete') {
                $faq = DB::table('faq_details')->where('id', $request->faq_id)->first();
                if ($faq) {
                    $col = ($request->slot == 1) ? 'faq_image_1' : 'faq_image_2';
                    $oldPath = $faq->$col;

                    if (!empty($oldPath)) {
                        $fullPath = public_path($oldPath);
                        if (File::exists($fullPath)) {
                            File::delete($fullPath);
                        }
                    }

                    DB::table('faq_details')->where('id', $request->faq_id)->update([
                        $col => null,
                        'updated_at' => now()
                    ]);

                    return response()->json(['status' => 'success']);
                }
            }

            // ------------------------------------------
            // 🎨 Gallery: คลังภาพผลงาน
            // ------------------------------------------
            elseif ($request->type == 'gallery_sort') {
                foreach ($request->order as $item) {
                    DB::table('galleries')->where('id', $item['id'])->update([
                        'sort_order' => $item['sort_order'],
                        'updated_at' => now()
                    ]);
                }
                return response()->json(['status' => 'success']);
            }

            elseif ($request->type == 'gallery_delete') {
                $gallery = DB::table('galleries')->where('id', $request->id)->first();
                if ($gallery) {
                    $path = public_path('images/gallery/' . $gallery->image_path);
                    if (File::exists($path)) File::delete($path);
                    DB::table('galleries')->where('id', $request->id)->delete();
                }
            }

            elseif ($request->type == 'gallery_upload') {
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        // Path: public/images/gallery
                        $file->move(public_path('images/gallery'), $filename);
                        DB::table('galleries')->insert([
                            'product_id' => $request->product_id,
                            'image_path' => $filename,
                            'created_at' => now(), 'updated_at' => now()
                        ]);
                    }
                    return response()->json(['status' => 'success']);
                }
            }

            // ------------------------------------------
            // 🧩 Addons: อุปกรณ์เสริม (Parts)
            // ------------------------------------------
            elseif ($request->type == 'part_add') {
                $newId = DB::table('product_parts')->insertGetId([
                    'product_id' => $request->product_id,
                    'part_name' => 'อุปกรณ์ใหม่ (รอแก้ไข)',
                    'color' => 'ระบุสี', 
                    'price_extra' => 0.00,
                    'created_at' => now(), 
                    'updated_at' => now()
                ]);
                return response()->json(['status' => 'success', 'id' => $newId]);
            }

            elseif ($request->type == 'part_update') {
                $updateData = [
                    'part_name' => $request->part_name,
                    'color' => $request->color,
                    'price_extra' => $request->price_extra,
                    'updated_at' => now()
                ];
                
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    // Path: public/images/jp-attachments/attachments
                    $file->move(public_path('images/jp-attachments/attachments'), $filename);
                    $updateData['image_url'] = $filename;
                }
                
                DB::table('product_parts')->where('id', $request->id)->update($updateData);
            }

            elseif ($request->type == 'part_delete') {
                DB::table('product_parts')->where('id', $request->id)->delete();
            }

            // --- Default Success ---
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            // ส่ง Error กลับไปให้ JavaScript แสดง Alert
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}   