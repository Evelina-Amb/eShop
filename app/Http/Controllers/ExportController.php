<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function listings(): Response
    {
        // VISI non-hidden listingai ir neisparduoti
        $listings = Listing::query()
            ->where('is_hidden', false)
            ->where('statusas', '!=', 'parduotas')
            ->with(['category', 'photos', 'user'])
            ->get();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><listings/>');

        foreach ($listings as $l) {
            $node = $xml->addChild('listing');
            $node->addChild('id', (string) $l->id);
            $node->addChild('pavadinimas', htmlspecialchars((string) $l->pavadinimas));
            $node->addChild('aprasymas', htmlspecialchars((string) $l->aprasymas));
            $node->addChild('kaina', (string) $l->kaina);
            $node->addChild('tipas', (string) $l->tipas);
            $node->addChild('statusas', (string) $l->statusas);
            $node->addChild('is_hidden', (string) (int) $l->is_hidden);

            $node->addChild('category_id', (string) $l->category_id);
            $node->addChild('category', htmlspecialchars((string) optional($l->category)->pavadinimas));

            $node->addChild('user_id', (string) $l->user_id);

            $node->addChild('created_at', (string) $l->created_at);
            $node->addChild('updated_at', (string) $l->updated_at);

            $photos = $node->addChild('photos');
            foreach ($l->photos ?? [] as $p) {
                $photos->addChild('photo', htmlspecialchars((string) $p->failo_url));
            }
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
