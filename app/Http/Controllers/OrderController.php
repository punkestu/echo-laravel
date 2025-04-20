<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Order;
use App\Rules\RequiredIfStatusIn;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

enum Jaminan: string
{
    case KTP = 'KTP';
    case SIM = 'SIM';
}

enum Pengambilan: string
{
    case Ambil_di_Rumah = 'Ambil di Rumah';
    case COD = 'COD';
}

enum Status: string
{
    case Dipesan = 'dipesan';
    case DP = 'DP';
    case Lunas = 'lunas';
    case Diproses = 'diproses';
    case Dibawa = 'dibawa';
    case Dikembalikan = 'dikembalikan';
    case Selesai = 'selesai';
    case Batal = 'batal';
}

class OrderController
{
    public function index()
    {
        $orders = Order::with(["user", "catalogs" => function ($query) {
            $query->withPivot('qty');
        }]);
        $statuses = Status::cases();
        $search = request('search');
        if ($search) {
            $orders->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('jaminan', 'like', "%{$search}%")
                    ->orWhere('pengambilan', 'like', "%{$search}%")
                    ->orWhere('tempat_cod', 'like', "%{$search}%")
                    ->orWhere('jam_ambil', 'like', "%{$search}%")
                    ->orWhere('jam_kembali', 'like', "%{$search}%");
            });
        }
        $orders = $orders->get();
        return view('dashboard.order.index', [
            'orders' => $orders,
            'search' => $search,
            'statuses' => $statuses,
        ]);
    }

    public function create()
    {
        $catalogs = Catalog::all();
        $jaminans = Jaminan::cases();
        $pengambilans = Pengambilan::cases();
        return view('dashboard.order.create', [
            'catalogs' => $catalogs,
            'jaminans' => $jaminans,
            'pengambilans' => $pengambilans,
        ]);
    }

    public function edit($id)
    {
        $order = Order::with(['catalogs' => function ($query) {
            $query->withPivot('qty');
        }])->findOrFail($id);
        $catalogs = Catalog::all();
        $jaminans = Jaminan::cases();
        $pengambilans = Pengambilan::cases();
        $statuses = [
            'dipesan' => ['dipesan', 'DP', 'lunas', 'batal'],
            'DP' => ['DP', 'lunas', 'batal'],
            'lunas' => ['lunas', 'diproses', 'dibawa', 'batal'],
            'diproses' => ['diproses', 'dibawa', 'batal'],
            'dibawa' => ['dibawa', 'dikembalikan', 'selesai', 'batal'],
            'dikembalikan' => ['dikembalikan', 'selesai', 'batal'],
            'selesai' => ['selesai', 'batal'],
            'batal' => ['batal'],
        ];
        $status_disabled = [
            'dipesan' => ['name', 'nohp', 'alamat'],
            'DP' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'bukti_dp'],
            'lunas' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'bukti_dp', 'bukti_lunas'],
            'diproses' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'bukti_dp', 'bukti_lunas'],
            'dibawa' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'jaminan', 'pengambilan', 'tempat_cod', 'jam_ambil', 'jam_kembali', 'bukti_dp', 'bukti_lunas', 'bukti_dibawa'],
            'dikembalikan' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'jaminan', 'pengambilan', 'tempat_cod', 'jam_ambil', 'bukti_dp', 'bukti_lunas', 'bukti_dibawa', 'bukti_kembali'],
            'selesai' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'jaminan', 'pengambilan', 'tempat_cod', 'jam_ambil', 'bukti_dp', 'bukti_lunas', 'bukti_dibawa', 'bukti_kembali'],
            'batal' => ['name', 'nohp', 'alamat', 'catalogs', 'dp', 'jaminan', 'pengambilan', 'tempat_cod', 'jam_ambil', 'bukti_dp', 'bukti_lunas', 'bukti_dibawa', 'bukti_kembali'],
        ];
        return view('dashboard.order.edit', [
            'order' => $order,
            'catalogs' => $catalogs,
            'jaminans' => $jaminans,
            'pengambilans' => $pengambilans,
            'statuses' => $statuses,
            'status_disabled' => $status_disabled[$order->status],
        ]);
    }

    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'nohp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jaminan' => ['required', new Enum(Jaminan::class)],
            'pengambilan' => ['required', new Enum(Pengambilan::class)],
            'tempat_cod' => 'nullable|string|max:255',
            'jam_ambil' => 'required|date_format:Y-m-d\TH:i',
            'jam_kembali' => 'required|date_format:Y-m-d\TH:i',
            'price' => 'required|integer|min:0',
            'catalogs' => 'required|array',
            'catalogs.*.id' => 'exists:catalogs,id',
            'catalogs.*.qty' => 'required|integer|min:1',
        ], [
            'user_id.exists' => 'Member tidak ditemukan',
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
            'nohp.required' => 'No HP harus diisi',
            'nohp.string' => 'No HP harus berupa string',
            'nohp.max' => 'No HP maksimal 255 karakter',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.string' => 'Alamat harus berupa string',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'jaminan.required' => 'Jaminan harus diisi',
            'jaminan.enum' => 'Jaminan tidak valid',
            'pengambilan.required' => 'Pengambilan harus diisi',
            'pengambilan.enum' => 'Pengambilan tidak valid',
            'tempat_cod.required' => 'Tempat COD harus diisi',
            'tempat_cod.string' => 'Tempat COD harus berupa string',
            'tempat_cod.max' => 'Tempat COD maksimal 255 karakter',
            'jam_ambil.required' => 'Jam ambil harus diisi',
            'jam_ambil.date_format' => 'Jam ambil tidak valid',
            'jam_kembali.required' => 'Jam kembali harus diisi',
            'jam_kembali.date_format' => 'Jam kembali tidak valid',
            'price.required' => 'Harga harus diisi',
            'price.integer' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0',
            'catalogs.*.id.exists' => 'Catalog tidak ditemukan',
            'catalogs.*.qty.required' => 'Jumlah catalog harus diisi',
            'catalogs.*.qty.integer' => 'Jumlah catalog harus berupa angka',
            'catalogs.*.qty.min' => 'Jumlah catalog minimal 1',
            'catalogs.required' => 'Catalog harus dipilih',
            'catalogs.array' => 'Catalog harus berupa array'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                'type' => 'error',
                'message' => 'Gagal membuat order, silahkan periksa kembali data yang anda masukkan.',
            ])->withErrors($validation)->withInput();
        }

        $order = Order::create([
            'user_id' => $request->user_id,
            'nama' => $request->name,
            'no_telp' => $request->nohp,
            'alamat' => $request->alamat,
            'jaminan' => $request->jaminan,
            'pengambilan' => $request->pengambilan,
            'tempat_cod' => $request->tempat_cod,
            'jam_ambil' => $request->jam_ambil,
            'jam_kembali' => $request->jam_kembali,
            'status' => 'dipesan',
            'price' => $request->price,
        ]);
        foreach ($request->catalogs as $catalog) {
            $order->catalogs()->attach($catalog['id'], ['qty' => $catalog['qty']]);
        }

        \App\Models\Customer::registernewCustomer($request->name, $request->nohp);

        return redirect()->route('dashboard.order')->with('success', 'Order created successfully.');
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validation = validator($request->all(), [
            'status' => ['required', new Enum(Status::class)],
            'jaminan' => [
                Rule::requiredIf(in_array($request->status, ['dipesan', 'DP', 'lunas'])),
                new Enum(Jaminan::class)
            ],
            'pengambilan' => [
                Rule::requiredIf(in_array($request->status, ['dipesan', 'DP', 'lunas'])),
                new Enum(Pengambilan::class)
            ],
            'tempat_cod' => 'nullable|string|max:255',
            'jam_ambil' => [
                Rule::requiredIf(in_array($order->status, ['dipesan'])),
                'date_format:Y-m-d\TH:i'
            ],
            'jam_kembali' => [
                Rule::requiredIf(in_array($order->status, ['dipesan'])),
                'date_format:Y-m-d\TH:i'
            ],
            'price' => [
                Rule::requiredIf(in_array($order->status, ['dipesan'])),
                'integer',
                'min:0'
            ],
            'bukti_dp' => [
                Rule::requiredIf(in_array($request->status, ['DP']) && $order->bukti_dp == null),
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'bukti_lunas' => [
                Rule::requiredIf(in_array($request->status, ['lunas']) && $order->bukti_lunas == null),
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'bukti_dibawa' => [
                Rule::requiredIf(in_array($request->status, ['diproses']) && $order->bukti_dibawa == null),
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'bukti_kembali' => [
                Rule::requiredIf(in_array($request->status, ['dibawa']) && $order->bukti_kembali == null),
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'catalogs' => [
                Rule::requiredIf(in_array($order->status, ['dipesan'])),
                'array'
            ],
            'catalogs.*.id' => 'exists:catalogs,id',
            'catalogs.*.qty' => 'required|integer|min:1'
        ], [
            'status.required' => 'Status harus diisi',
            'status.enum' => 'Status tidak valid',
            'jaminan.required' => 'Jaminan harus diisi',
            'jaminan.enum' => 'Jaminan tidak valid',
            'pengambilan.required' => 'Pengambilan harus diisi',
            'pengambilan.enum' => 'Pengambilan tidak valid',
            'tempat_cod.required' => 'Tempat COD harus diisi',
            'tempat_cod.string' => 'Tempat COD harus berupa string',
            'tempat_cod.max' => 'Tempat COD maksimal 255 karakter',
            'jam_ambil.required' => 'Jam ambil harus diisi',
            'jam_ambil.date_format' => 'Jam ambil tidak valid',
            'jam_kembali.required' => 'Jam kembali harus diisi',
            'jam_kembali.date_format' => 'Jam kembali tidak valid',
            'price.required' => 'Harga harus diisi',
            'price.integer' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0',
            'bukti_dp.required' => 'Bukti DP harus diisi',
            'bukti_dp.image' => 'Bukti DP harus berupa gambar',
            'bukti_dp.mimes' => 'Bukti DP harus berupa file dengan ekstensi jpeg, png, jpg, gif',
            'bukti_dp.max' => 'Bukti DP maksimal 2MB',
            'bukti_lunas.required' => 'Bukti Lunas harus diisi',
            'bukti_lunas.image' => 'Bukti Lunas harus berupa gambar',
            'bukti_lunas.mimes' => 'Bukti Lunas harus berupa file dengan ekstensi jpeg, png, jpg, gif',
            'bukti_lunas.max' => 'Bukti Lunas maksimal 2MB',
            'bukti_dibawa.required' => 'Bukti Dibawa harus diisi',
            'bukti_dibawa.image' => 'Bukti Dibawa harus berupa gambar',
            'bukti_dibawa.mimes' => 'Bukti Dibawa harus berupa file dengan ekstensi jpeg, png, jpg, gif',
            'bukti_dibawa.max' => 'Bukti Dibawa maksimal 2MB',
            'bukti_kembali.required' => 'Bukti Kembali harus diisi',
            'bukti_kembali.image' => 'Bukti Kembali harus berupa gambar',
            'bukti_kembali.mimes' => 'Bukti Kembali harus berupa file dengan ekstensi jpeg, png, jpg, gif',
            'bukti_kembali.max' => 'Bukti Kembali maksimal 2MB',
            'catalogs.required' => 'Catalog harus dipilih',
            'catalogs.array' => 'Catalog harus berupa array',
            'catalogs.*.id.exists' => 'Catalog tidak ditemukan',
            'catalogs.*.qty.required' => 'Jumlah catalog harus diisi',
            'catalogs.*.qty.integer' => 'Jumlah catalog harus berupa angka',
            'catalogs.*.qty.min' => 'Jumlah catalog minimal 1'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                'type' => 'error',
                'message' => 'Gagal memperbarui order, silahkan periksa kembali data yang anda masukkan.',
            ])->withErrors($validation)->withInput();
        }
        if ($order->status == 'dipesan') {
            $order->status = $request->status;
            $order->jaminan = $request->jaminan;
            $order->pengambilan = $request->pengambilan;
            $order->tempat_cod = $request->tempat_cod;
            $order->jam_ambil = $request->jam_ambil;
            $order->jam_kembali = $request->jam_kembali;
            $order->price = $request->price;
            if ($request->hasFile('bukti_dp')) {
                $order->bukti_dp = $request->file('bukti_dp')->store('uploads/bukti_dp', 'public');
            }
            if ($request->hasFile('bukti_lunas')) {
                $order->bukti_lunas = $request->file('bukti_lunas')->store('uploads/bukti_lunas', 'public');
            }
            $order->catalogs()->detach();
            foreach ($request->catalogs as $catalog) {
                $order->catalogs()->attach($catalog['id'], ['qty' => $catalog['qty']]);
            }
        } else if ($order->status == 'DP' || $order->status == 'lunas' || $order->status == 'diproses') {
            $order->jaminan = $request->jaminan;
            $order->pengambilan = $request->pengambilan;
            $order->tempat_cod = $request->tempat_cod;
            $order->jam_ambil = $request->jam_ambil;
            $order->jam_kembali = $request->jam_kembali;
            if ($order->status == 'DP' && $request->hasFile('bukti_lunas')) {
                $order->bukti_lunas = $request->file('bukti_lunas')->store('uploads/bukti_lunas', 'public');
            }
            if (($order->status == 'lunas' || $order->status == 'diproses') && $request->hasFile('bukti_dibawa')) {
                $order->bukti_dibawa = $request->file('bukti_dibawa')->store('uploads/bukti_dibawa', 'public');
            }
            $order->status = $request->status;
        } else {
            if ($order->status == 'dibawa' && $request->hasFile('bukti_kembali')) {
                $order->bukti_kembali = $request->file('bukti_kembali')->store('uploads/bukti_kembali', 'public');
            }
            $order->status = $request->status;
        }

        $order->save();
        return redirect()->route('dashboard.order')->with('alert', [
            'type' => 'success',
            'message' => 'Order updated successfully.',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validation = validator($request->only('status'), [
            'status' => ['required', new Enum(Status::class)],
        ], [
            'status.required' => 'Status harus diisi',
            'status.enum' => 'Status tidak valid',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                'type' => 'error',
                'message' => 'Gagal memperbarui status order, silahkan periksa kembali data yang anda masukkan.',
            ])->withErrors($validation)->withInput();
        }
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);
        return redirect()->route('dashboard.order')->with('alert', [
            'type' => 'success',
            'message' => 'Order status updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->catalogs()->detach();
        $order->delete();
        return redirect()->route('dashboard.order')->with('alert', [
            'type' => 'success',
            'message' => 'Order deleted successfully.',
        ]);
    }

    public function api_getItems($id)
    {
        $items = Order::with(["catalogs" => function ($query) {
            $query->withPivot('qty')->with(['items' => function ($query) {
                $query->withPivot('qty')->select(['items.id', 'name']);
            }])->select(['catalogs.id', 'name']);
        }])->findOrFail($id);

        $items = $items->catalogs->reduce(function ($carry, $catalog) {
            foreach ($catalog->items as $item) {
                if (!isset($carry[$item->id])) {
                    $carry[$item->id] = [
                        'name' => $item->name,
                        'qty' => $catalog->pivot->qty * $item->pivot->qty,
                    ];
                } else {
                    $carry[$item->id]['qty'] += $catalog->pivot->qty * $item->pivot->qty;
                }
            }
            return $carry;
        }, []);
        $items = array_values($items);

        return response()->json([
            'items' => $items
        ]);
    }
}
