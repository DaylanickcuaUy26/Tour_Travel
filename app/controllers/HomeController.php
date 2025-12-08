<?php

class HomeController extends Controller {
    public function index() {
        // Load the package model
        $packageModel = $this->model('PackageModel');

        // Get data from the model
        $packages = $packageModel->getFeaturedPackages();
        $locations = $packageModel->getDistinctLocations();

        // Prepare data for the view
        $data = [
            'packages' => $packages,
            'locations' => $locations
        ];

        // Load the view and pass data
        $this->view('home/index', $data);
    }
}
