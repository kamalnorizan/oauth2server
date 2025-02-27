<?php
namespace App\Http\Controllers\Passport;

use App\Models\SubSystem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Laravel\Passport\Bridge\Scope;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\Contracts\AuthorizationViewResponse;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Laravel\Passport\Http\Controllers\AuthorizationController;

class CustomAuthorizationController extends AuthorizationController
{
    public function __construct(AuthorizationServer $server, AuthorizationViewResponse $response)
    {
        $guard = Auth::guard(config('auth.defaults.guard', 'web'));

        parent::__construct($server, $guard, $response);
    }

    public function authorize(ServerRequestInterface $psrRequest, Request $request, ClientRepository $clients, TokenRepository $tokens)
    {
        $clientId = $request->input('client_id');
        $subSystem = SubSystem::where('client_id', $clientId)->with('scopes')->first();

        if (!$subSystem) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $scopes = $subSystem->scopes->pluck('scope')->toArray();

        if (empty($scopes)) {
            $scopes = ['profile-user']; // Default scope if none exist
        }

        foreach ($scopes as $key => $scope) {
            $scopes[$key] = new Scope($scope);
        }

        $authRequest = $this->withErrorHandling(function () use ($psrRequest) {
            return $this->server->validateAuthorizationRequest($psrRequest);
        });

        $authRequest->setScopes($scopes);

        if ($this->guard->guest()) {
            return $request->get('prompt') === 'none'
                    ? $this->denyRequest($authRequest)
                    : $this->promptForLogin($request);
        }

        if ($request->get('prompt') === 'login' &&
            ! $request->session()->get('promptedForLogin', false)) {
            $this->guard->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $this->promptForLogin($request);
        }

        $request->session()->forget('promptedForLogin');


        $scopes = $this->parseScopes($authRequest);
        $user = $this->guard->user();
        $client = $clients->find($authRequest->getClient()->getIdentifier());

        $userSubSystem = $user->usersubsystems->pluck('sub_system_id')->toArray();
        if(!in_array($subSystem->id, $userSubSystem)){
            return $this->denyRequest($authRequest, $user);

        }

        if ($request->get('prompt') !== 'consent' &&
            ($client->skipsAuthorization() || $this->hasValidToken($tokens, $user, $client, $scopes))) {
            return $this->approveRequest($authRequest, $user);
        }

        if ($request->get('prompt') === 'none') {
            return $this->denyRequest($authRequest, $user);
        }

        $request->session()->put('authToken', $authToken = Str::random());
        $request->session()->put('authRequest', $authRequest);

        return $this->response->withParameters([
            'client' => $client,
            'user' => $user,
            'scopes' => $scopes,
            'request' => $request,
            'authToken' => $authToken,
        ]);
    }
}
