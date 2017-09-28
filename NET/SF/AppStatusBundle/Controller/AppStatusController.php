<?php

namespace NET\SF\AppStatusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Exception\RequestException;

class AppStatusController extends Controller {
    
    public function statusAction() {
        
        $request = Request::createFromGlobals();
        $symfonyVersion = \Symfony\Component\HttpKernel\Kernel::VERSION;
        $phpVersion = phpversion();
        $phpMemory = ini_get('memory_limit');
        $serverName = $request->server->get('SERVER_NAME');
       
            $name= $this->container->getParameter("name");
            $url = $this->container->getParameter("url");
            $description = $this->container->getParameter("description");
            $client = new \GuzzleHttp\Client(['verify' => false]);
            try {
                $response = $client->request('GET', $url, ['timeout' => 10,
                    'connect_timeout' => 2]);

                $statusCode = $response->getStatusCode();
                
            } catch (RequestException $ex) {
                if ($ex->getCode() == 0) {
                    $statusCode = $ex->getCode();
                }

            }
            $dataStatusUrl[] = array(
                                    "groupe" => "Service",
                                    "name" => $name,
                                    "description" => $description,
                                    "code" => $statusCode,
                                     );
            
            $dataParameters = array(
                                    "Host" => array(
                                        'ServerAddress' => $request->server->get('SERVER_ADDR'),
                                        'ServerName' => $serverName
                                    ),
                                    "PhpEngine" => array(
                                        'ApacheVersion' => $request->server->get('SERVER_SOFTWARE'),
                                        'PhpVersion' => $phpVersion,
                                        'PhpMemory_Limit' => $phpMemory,
                                        'SymfonyVersion' => $symfonyVersion
                                    )
                                );
     
                    return $this->render('NETSFAppStatusBundle:AppStatus:status.html.twig', array(
                                        'dataParameters' => $dataParameters,
                                        'dataStatus' => $dataStatusUrl,
                                            )
        );
    }
}
