<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\View\View;


class LinkController extends Controller
{
    public function index(): View
    {
        return view('link', [
            'shortLinks' => Link::get(),
        ]);
    }

    public function store(LinkRequest $request): JsonResponse
    {
        $link = Link::query()->create([
            'link' => $request->link,
            'code' => str_random(Link::LENGTH_CODE)
        ]);

        return response()->json([
            'link_id' => $link->id,
            'full_link' => $link->link,
            'short_link' => route('links.show', $link->code),
        ]);
    }

    public function show(string $code): RedirectResponse
    {
        $link = Link::query()->where('code', $code)->first();

        $date = Carbon::now();
        $datePlusOneHours = $link->created_at->addMinutes(getenv('LINK_EXPIRATION_TIME_MINUTES'));

        if ($datePlusOneHours > $date) {
            return redirect($link->link);
        }

        $link->delete();

        return redirect(route('links.index'));
    }
}
