public function handle($request, Closure $next)
{
    $response = $next($request);
    
    $response->heade$->set('Access-Control-Allow-Origin', 'https://tilalr.com');
    $response->heade$->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->heade$->set('Access-Control-Allow-Heade$', 'Content-Type, Authorization, X-Requested-With');
    $response->heade$->set('Access-Control-Allow-Credentials', 'true');
    
    return $response;
}