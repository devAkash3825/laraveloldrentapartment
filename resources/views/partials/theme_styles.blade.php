@php
    $settings = DB::table('settings')->pluck('value', 'key');
    if (!function_exists('hexToRgb')) {
        function hexToRgb($hex) {
            $hex = str_replace("#", "", $hex);
            if(strlen($hex) == 3) {
                $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            } else {
                $r = hexdec(substr($hex,0,2));
                $g = hexdec(substr($hex,2,2));
                $b = hexdec(substr($hex,4,2));
            }
            return "$r, $g, $b";
        }
    }
    $siteColor = $settings['site_default_color'] ?? '#0D7C66';
    $btnColor = $settings['site_btn_color'] ?? '#0D7C66';
    $gradientColor = $settings['site_gradient_color'] ?? '#398E91';
@endphp
<style>
    :root {
        --colorPrimary: {{ $siteColor }};
        --colorPrimaryRgb: {{ hexToRgb($siteColor) }};
        --btnColor: {{ $btnColor }};
        --btnColorRgb: {{ hexToRgb($btnColor) }};
        --gradientColor: {{ $gradientColor }};
        --gradientColorRgb: {{ hexToRgb($gradientColor) }};
        
        /* Additional Common Vars */
        --textMain: #334155;
        --textMuted: #64748b;
        --bgLight: #f8fafc;
    }
</style>
