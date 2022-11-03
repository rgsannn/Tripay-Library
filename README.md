# Tripay-Library
PHP Library To Interact With All APIs From https://tripay.co.id/

Full Documentation, Please Visit : https://tripay.co.id/developer

### Instalasi
Untuk dapat menggunakan fungsi ini di harapkan anda sudah mempunyai data yang di perlukan seperti API KEY, PRIVATE KEY & MERCHANT CODE Tripay. Berikut contoh kode untuk memanggil fungsi ini
```
require 'Tripay.php';

$Tripay = new Tripay([
    'ApiKey' => '', // YOUR API KEY
    'PrivateKey' => '', // YOUR PRIVATE KEY
    'MerchantCode' => '', // YOUR MERCHANT CODE
    'Status' => 'Development', // Development Or Production
    'SandBox' => [
        'ApiKey' => '', // YOUR SANDBOX API KEY (OPTIONAL)
        'PrivateKey' => '', // YOUR SANDBOX PRIVATE KEY (OPTIONAL)
        'MerchantCode' => '', // YOUR SANDBOX MERCHANT CODE (OPTIONAL)
    ]
]);
```
Silahkan Cek File [Example-Usage.php](Example-Usage.php) Untuk Lebih Detailnya

### PEMBAYARAN
- #### Instruksi Pembayaran
  [Documentation](https://tripay.co.id/developer?tab=payment-instruction)
  
  API ini digunakan untuk mengambil instruksi pembayaran dari masing-masing channel
  
  Format Penulisan :
  ```
  $Tripay->PaymentInstructions([
      'code' => 'BRIVA', // Required
      'pay_code' => '1234567890', // Optional
      'amount' => 10000, // Optional
      'allow_html' => 1, // Optional
  ]);
  ```
  
### MERCHANT
- #### Channel Pembayaran
  [Documentation](https://tripay.co.id/developer?tab=merchant-payment-channel)
  
  API ini digunakan untuk mendapatkan daftar channel pembayaran yang aktif pada akun Merchant Anda beserta informasi lengkap termasuk biaya transaksi dari masing-masing channel
  
  Format Penulisan :
  ```
  $Tripay->PaymentChannel([
      'code' => 'BRIVA' // Optional
  ]);
  ```
- #### Kalkulator Biaya
  [Documentation](https://tripay.co.id/developer?tab=merchant-fee-calculator)
  
  API ini digunakan untuk mendapatkan rincian perhitungan biaya transaksi untuk masing-masing channel berdasarkan nominal yang ditentukan
  
  Format Penulisan :
  ```
  $Tripay->FeeCalculator([
      'amount' => '10000', // Required
      'code' => 'BRIVA' // Optional
  ]);
  ```
- #### Daftar Transaksi
  [Documentation](https://tripay.co.id/developer?tab=merchant-transactions)
  
  API ini digunakan untuk mendapatkan daftar transaksi merchant

  Format Penulisan :
  ```
  $Tripay->ListTransactions([
      'page' => '1', // Optional
      'per_page' => '50', // Optional
      'sort' => 'desc', // Optional
      'reference' => 'T0001000000455HFGRY', // Optional
      'merchant_ref' => 'INV57564', // Optional
      'method' => 'BRIVA', // Optional
      'status' => 'PAID', // Optional
  ]);
  ```
### TRANSAKSI
- #### CLOSED PAYMENT
  - ##### Request Transaksi
    [Documentation](https://tripay.co.id/developer?tab=transaction-create)
    
    API ini digunakan untuk membuat transaksi baru atau melakukan generate kode pembayaran

    Format Penulisan :
    ```
    $Tripay->ReqTransactions([
        'method'         => 'BRIVA', // Required
        'merchant_ref'   => 'INV345675', // Optional
        'amount'         => '1000000', // Required
        'customer_name'  => 'Nama Pelanggan', // Required
        'customer_email' => 'emailpelanggan@domain.com', // Required
        'customer_phone' => '081234567890', // Optional (Required untuk beberapa channel)
        'order_items'    => [ // Required
            [
                'sku'         => 'FB-06',
                'name'        => 'Nama Produk 1',
                'price'       => 500000,
                'quantity'    => 1,
                'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
            ],
            [
                'sku'         => 'FB-07',
                'name'        => 'Nama Produk 2',
                'price'       => 500000,
                'quantity'    => 1,
                'product_url' => 'https://tokokamu.com/product/nama-produk-2',
                'image_url'   => 'https://tokokamu.com/product/nama-produk-2.jpg',
            ]
        ],
        'return_url'   => '', // Optional
    ]);
    ```
  - ##### Detail Transaksi
    [Documentation](https://tripay.co.id/developer?tab=transaction-detail)
    
    API ini digunakan untuk mengambil detail transaksi yang pernah dibuat. Dapat juga digunakan untuk cek status pembayaran
    
    Format Penulisan :
    ```
    $Tripay->DetailTransactions([
        'reference' => 'T0001000000000000006' // Required
    ]);
    ```
      
- #### OPEN PAYMENT
  COMING SOON
  
### CALLBACK
  COMING SOON
  
## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
