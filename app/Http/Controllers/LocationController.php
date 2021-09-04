<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//https://github.com/endroid/qr-code
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class LocationController extends Controller
{
    protected $basepath;

    function __construct()
    {
        $this->basepath = '/location';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = new Location();

        return view('location.create', compact('location') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $location = new Location;

        $location->name = $request->input('name');
        $location->code = $request->input('code');
        $location->description = $request->input('description');
        $location->organization_id = $user->organization->id;
  
        //save record with values
        $item_saved = $location->save();

        //handle item after saved
        if($item_saved) {
            //display message to display to user
            $request->session()->flash('message', 'Added location ' . $location->name);
            $request->session()->flash('status', 'success');
        } else {
            //display message to display to user
            $request->session()->flash('message', 'Unable to add location ' . $location->name);
            $request->session()->flash('status', 'error');
        }

        //redirect based on submit button
        if($location->id > 0) {
            $url = 'organization/' . $user->organization->code;
            return redirect($url);
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $seed = $location->code . $location->id;

        $hashed = hash('ripemd160', $seed);

        $url = url('checkin/' . $location->organization->code . '/' . $hashed);

        $qrcodeImage = $this->generateQrCode($url, 380);
        $qrcode = $qrcodeImage->getDataUri();

        return view('location.show', compact('location', 'qrcode') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('location.edit', compact('location') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $user = Auth::user();

        //update item
        $location->name = $request->input('name');
        $location->code = $request->input('code');
        $location->description = $request->input('description');

        $location->save();

        //display message to display to user
        $request->session()->flash('message', 'Successfully updated location');
        $request->session()->flash('status', 'success');

        //set redirect to include query tokens
        $redirectUri = $this->basepath . '/' . $location->code;

        return redirect($redirectUri);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //set to base path
        $redirectUri = $location->organization->code;

        //TODO: add checks and validation
        $location->delete();

        //redirect
        return redirect($redirectUri);  
    }

    /**
     * Output PDF for the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function pdf(Location $location)
    {
        $qrCode = $this->generateQrCode($location->url, 360);

        header("Content-Type: application/pdf");

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle($location->name);
        $mpdf->SetSubject($location->description);

        $mpdf->WriteHTML('<h1 align="center">' . $location->name . '</h1>');
        $mpdf->WriteHTML('<p align="center">' . $location->description . '</p>');
        $mpdf->Image($qrCode->getDataUri(), 55, 60);
        $mpdf->WriteHTML('<p align="center">' . $location->code . '</p>');
        $mpdf->WriteHTML('<p align="center">' . $location->url . '</p>');

        $mpdf->Output();

        exit;
    }

    private function generateQrCode(string $url, int $size = 300) {
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($url)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize($size)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);
        
        return $result;
    }    
}
