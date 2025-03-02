<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptedHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{


    public function index(Request $request)
    {
        return view("dashboard.kendaraan.index");
    }

    public function loadData(Request $request) 
    {
        try {
            $limit = 10;
            $page = 1;
            $order = "desc";
    
            if($request->has("limit")) {
                $limit = $request->input("limit");
            }
            if($request->has("page")) {
                $page = $request->input("page");
    
            }
            if($request->has("order")) {
                $order = $request->input("order");
            }
            
            if($request->has("search")) {
                $search = $request->input("search");
            }
    
            $data = Car::orderBy("created_at", $order)
                    ->where(function ($q) use ($search) {
                        $q->where('nopol', 'like', "%{$search}%")
                        ->orWhere('brand_kendaraan', 'like', "%{$search}%")
                        ->orWhere('model_kendaraan', 'like', "%{$search}%");
                    })
                    ->paginate($limit);
    
 
            $helper = new EncryptedHelper();
            $data = $data->through(function ($item) use ($helper) {
                $item->ref = $helper->secureEncode($item->id);
                unset($item->id); 
                return $item;
            });

            $data = $data->appends([
                'limit' => $limit,
                'page' => $page,
                'order' => $order,
            ]);


            return response()->json([
                "success" => true,
                "code" => Response::HTTP_OK,
                "message" => "logged in successfully",
                "data" => $data->items(),
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'next_page_url' => $data->nextPageUrl(),
                    'prev_page_url' => $data->previousPageUrl(),
                ],
            ], Response::HTTP_OK);
        } catch(Exception $e) {
            return response()->json([
                "success" => true,
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "message" => "Internal Server Error",
                "error" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CarStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $uploadedFiles = [];

            if ($request->hasFile("gambar")) {
                $filepath = "/storage/images/";

                if (!File::isDirectory($filepath)) {
                    File::makeDirectory($filepath, 0775, true, true);
                }

                foreach ($request->file("gambar") as $item) {
                    $fileName = time() . "-" . \Str::random(7) . "." . $item->extension();
                    $item->move(public_path($filepath, "mobil"), $fileName);

                    $uploadedFiles[] = $filepath . "/" . $fileName;
                }
            }

            Car::create([
                "nopol" => $request->input("nopol"),
                "brand_kendaraan" => $request->input("brand_kendaraan"),
                "model_kendaraan" => $request->input("model_kendaraan"),
                "kapasitas" => $request->input("kapasitas"),
                "filepath" => $filepath ?? null,
                "filename" => $fileName ?? null,
            ]);

            DB::commit();

            return response()->json([
                "success" => true,
                "code" => Response::HTTP_CREATED,
                "message" => "created data has been successfully",
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($uploadedFiles as $file) {
                if (File::exists($file)) {
                    File::delete($file);
                }
            }

            return response()->json([
                "success" => true,
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "message" => "Server Internal Error",
                "error" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CarUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $uploadedFiles = [];

            if ($request->hasFile("gambar")) {
                $filepath = "/storage/images/";

                if (!File::isDirectory($filepath)) {
                    File::makeDirectory($filepath, 0775, true, true);
                }

                foreach ($request->file("gambar") as $item) {
                    $fileName = time() . "-" . \Str::random(7) . "." . $item->extension();
                    $item->move(public_path($filepath, "mobil"), $fileName);

                    $uploadedFiles[] = $filepath . "/" . $fileName;
                }
            }

            $data = [];
            $data["nopol"] = $request->input("nopol");
            $data["brand_kendaraan"] = $request->input("brand_kendaraan");
            $data["model_kendaraan"] = $request->input("model_kendaraan");
            $data["kapasitas"] = $request->input("kapasitas");
            $data["filepath"] = $filepath ?? null;
            $data["filename"] = $fileName ?? null;

            $encryp = new EncryptedHelper();
            $id = $encryp->secureDecode($request->input("ref"));
            $car = Car::where("id", $id)->first();
            
            $car->update($data);

            DB::commit();

            return successResponse("Data has been successfully updated", Response::HTTP_OK);
        } catch(QueryException $e) {
            DB::rollBack();

            // Handle duplicate entry error (SQLSTATE[23000], code 1062)
            if ($e->errorInfo[1] == 1062) {
                return errorResponse("Nomor polisi sudah digunakan. Silakan gunakan nomor polisi lain.", Response::HTTP_BAD_REQUEST);
            }
    
            // Handle other query exceptions
            return errorResponse("Database error occurred", Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if any
            cleanupUploadedFiles($uploadedFiles);

            return errorResponse("Server Internal Error", Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $decode = new EncryptedHelper();
            $id = $decode->secureDecode($request->input('ref'));
            Car::where('id', $id)->delete();
            return successResponse("Data has been successfully deleted", Response::HTTP_OK);
        } catch(\Exception $e) {
            return errorResponse("Server Internal Error", Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
