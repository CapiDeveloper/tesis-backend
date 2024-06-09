<?php

namespace App\Services;


use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Encoders\AvifEncoder;

class ImageService
{
    public static function procesarYGuardar($imagenTemporal, $nombreOriginal, $ancho = null, $alto = null)
    {
        // Crear una instancia de ImageManager
        $manager = new ImageManager(Driver::class);

        // Leer la imagen utilizando ImageManager
        $imagen = $manager->read($imagenTemporal);

        // Redimensionar la imagen si se especifican dimensiones
        if ($ancho && $alto) {
            $imagen->resize($ancho, $alto, function ($constraint) {
                $constraint->aspectRatio(); // Mantener la relación de aspecto
                $constraint->upsize(); // Prevenir que la imagen se amplíe
            });
        }

        // Obtener la extensión del archivo original
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

        // Generar un nombre único base para la imagen sin extensión
        $nombreBase = uniqid();

        // Guardar la imagen en tres formatos: original, webp y avif
        $formatos = [
            'webp' => new WebpEncoder(quality: 65),
            'avif' => new AvifEncoder(quality: 50)
        ];
        $rutasGuardado = [];

        foreach ($formatos as $formato => $encoder) {
            $nombreImagen = "{$nombreBase}.{$formato}";
            $rutaGuardado = public_path('imagenes/') . $nombreImagen;

            if ($formato === 'original') {
                // Guardar en el formato original
                $imagen->encode()->save($rutaGuardado);
            } else {
                // Guardar en el formato especificado (webp o avif)
                $imagen->encode($encoder)->save($rutaGuardado);
            }

            $rutasGuardado[$formato] = $rutaGuardado;
        }

        // Devolver las rutas de las imágenes guardadas
        return $nombreBase;
    }
}