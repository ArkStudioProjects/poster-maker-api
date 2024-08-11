<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    public function list( $path = '' )
    {
        $path_prefix = 'public/assets/';
        $path = $path_prefix.$path;

        $directories = Storage::directories( $path );
        $directories = collect( $directories )->map( function( $dir ) use ($path_prefix) {
            return route('asset-library', ['path' => Str::after( $dir, $path_prefix)]);
        } );

        $files = Storage::files( $path );
        $files = collect( $files )->map( function( $file ) use ($path_prefix) {
            return asset( 'media/assets/'.Str::after( $file, $path_prefix) );
        } );

        return [
            'files' => $files,
            'directories' => $directories,
        ];
    }
}
