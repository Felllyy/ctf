// rules/virus_rules.yar
// This rule is designed to identify valid image files.

rule is_image_file
{
    meta:
        description = "Detect common image file formats"
        author = "Rizal"
        date = "2025-08-12"

    strings:
        // PNG signature: 89 50 4E 47 0D 0A 1A 0A
        $png = { 89 50 4E 47 0D 0A 1A 0A }

        // JPEG Start Of Image (SOI): FF D8 FF
        $jpeg = { FF D8 FF }

        // GIF signature: GIF87a or GIF89a
        $gif1 = "GIF87a"
        $gif2 = "GIF89a"

        // BMP signature: BM
        $bmp = { 42 4D }

        // TIFF signatures: II* or MM* (little/big endian)
        $tiff1 = { 49 49 2A 00 }
        $tiff2 = { 4D 4D 00 2A }

        // WebP signature: RIFF....WEBP
        $webp_riff = "RIFF"
        $webp_webp = "WEBP"

    condition:
        $png at 0 or
        $jpeg at 0 or
        $gif1 at 0 or
        $gif2 at 0 or
        $bmp at 0 or
        $tiff1 at 0 or
        $tiff2 at 0 or
        ($webp_riff at 0 and $webp_webp at 8)
}
