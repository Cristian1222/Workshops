<?php
class DashboardController extends Controller {
    public function index(): void { $this->auth(); $this->view('dashboard/index'); }
}
