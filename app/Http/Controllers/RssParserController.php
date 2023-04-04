<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RssParserController extends Controller
{
    public function index(Request $request)
    {
        $feed = 'http://feeds.seroundtable.com/SearchEngineRoundtableFull';
        $xml = file_get_contents($feed);
        $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$xml) {
            $error = 'There was an error parsing XML.';
            return view('rssparser')->with([
                'error' => $error,
            ]);
        }

        $json = json_encode($xml);
        if (!$json) {
            $error = 'There was an error parsing XML.';
            return view('rssparser')->with([
                'error' => $error,
            ]);
        }

        $result = json_decode($json, true);
        $response = [];
        $count = 0;
        foreach ($result['item'] as $item) {
            if (
                substr_count($item['title'], "Google") > 0 ||
                substr_count($item['description'], "Google") > 0
            ) {
                $count += substr_count($item['title'], "Google");
                $count += substr_count($item['description'], "Google");
                $item['title'] = str_replace(
                    "Google",
                    "<span style='background-color:yellow;'>Google</span>",
                    $item['title']
                );
                $item['description'] = str_replace(
                    "Google",
                    "<span style='background-color:yellow;'>Google</span>",
                    $item['description']
                );
                $response[] = $item;
            }
        }

        return view('rssparser')->with([
            'feed'    => $feed,
            'count'   => $count,
            'results' => $response,
        ]);
    }
}
