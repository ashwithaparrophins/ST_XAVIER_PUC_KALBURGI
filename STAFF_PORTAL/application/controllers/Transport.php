<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
require_once 'vendor/autoload.php';
class Transport extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transport_model', 'transport');
        $this->load->model('students_model', 'student');
        $this->load->library('excel');
        $this->isLoggedIn();
    }
    function viewBusListing()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $vehicle_number = $this->security->xss_clean($this->input->post('vehicle_number'));
            $insurance_expiry_date = $this->security->xss_clean($this->input->post('insurance_expiry_date'));
            $emission_expiry_date = $this->security->xss_clean($this->input->post('emission_expiry_date'));
            $permit_date = $this->security->xss_clean($this->input->post('permit_date'));
            $tax_expiry_date = $this->security->xss_clean($this->input->post('tax_expiry_date'));
            $fitness_certificate_expiry_date = $this->security->xss_clean($this->input->post('fitness_certificate_expiry_date'));

            $route = $this->security->xss_clean($this->input->post('route'));
            $driver_name = $this->security->xss_clean($this->input->post('driver_name'));
            $driver_mobile = $this->security->xss_clean($this->input->post('driver_mobile'));
            $total_seat_capacity = $this->security->xss_clean($this->input->post('total_seat_capacity'));

            $data['vehicle_number'] = $vehicle_number;
            $data['route'] = $route;
            $data['driver_name'] = $driver_name;
            $data['driver_mobile'] = $driver_mobile;
            $data['total_seat_capacity'] = $total_seat_capacity;

            $filter['vehicle_number'] = $vehicle_number;
            $filter['route'] = $route;
            $filter['driver_name'] = $driver_name;
            $filter['driver_mobile'] = $driver_mobile;
            $filter['total_seat_capacity'] = $total_seat_capacity;

            if (!empty($insurance_expiry_date)) {
                $filter['insurance_expiry_date'] = date('Y-m-d', strtotime($insurance_expiry_date));
                $data['insurance_expiry_date'] = date('d-m-Y', strtotime($insurance_expiry_date));
            } else {
                $data['insurance_expiry_date'] = '';
            }

            if (!empty($emission_expiry_date)) {
                $filter['emission_expiry_date'] = date('Y-m-d', strtotime($emission_expiry_date));
                $data['emission_expiry_date'] = date('d-m-Y', strtotime($emission_expiry_date));
            } else {
                $data['emission_expiry_date'] = '';
            }

            if (!empty($permit_date)) {
                $filter['permit_date'] = date('Y-m-d', strtotime($permit_date));
                $data['permit_date'] = date('d-m-Y', strtotime($permit_date));
            } else {
                $data['permit_date'] = '';
            }

            if (!empty($tax_expiry_date)) {
                $filter['tax_expiry_date'] = date('Y-m-d', strtotime($tax_expiry_date));
                $data['tax_expiry_date'] = date('d-m-Y', strtotime($tax_expiry_date));
            } else {
                $data['tax_expiry_date'] = '';
            }

            if (!empty($fitness_certificate_expiry_date)) {
                $filter['fitness_certificate_expiry_date'] = date('Y-m-d', strtotime($fitness_certificate_expiry_date));
                $data['fitness_certificate_expiry_date'] = date('d-m-Y', strtotime($fitness_certificate_expiry_date));
            } else {
                $data['fitness_certificate_expiry_date'] = '';
            }



            $this->load->library('pagination');
            $count = $this->transport->getAllBusCount($filter);
            $returns = $this->paginationCompress("viewBusListing/", $count, 100);
            $data['totalBusCount'] = $count;
            $data['routeInfo'] = $this->transport->getRouteInfo();
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['BusInfo'] = $this->transport->getAllBusInfo($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Bus Details';
            $this->loadViews("transport/busDetail.php", $this->global, $data, NULL);
        }
    }


    public function addNewBus()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('vehicle_number', 'Vehicle Number', 'trim|required');
            $this->form_validation->set_rules('insurance_expiry_date', 'Insurance Expiry Date', 'trim|required');
            $this->form_validation->set_rules('route', 'Route', 'trim|required');
            $this->form_validation->set_rules('driver_name', 'Driver Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('driver_mobile', 'Driver Mobile', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('total_seat_capacity', 'Total Seat Capacity', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewBusListing();
            } else {
                $vehicle_number = $this->security->xss_clean($this->input->post('vehicle_number'));
                $insurance_expiry_date = $this->security->xss_clean($this->input->post('insurance_expiry_date'));
                $emission_expiry_date = $this->security->xss_clean($this->input->post('emission_expiry_date'));
                $permit_date = $this->security->xss_clean($this->input->post('permit_date'));
                $tax_expiry_date = $this->security->xss_clean($this->input->post('tax_expiry_date'));
                $fitness_certificate_expiry_date = $this->security->xss_clean($this->input->post('fitness_certificate_expiry_date'));
                $route = $this->security->xss_clean($this->input->post('route'));
                $driver_name = $this->security->xss_clean($this->input->post('driver_name'));
                $driver_mobile = $this->security->xss_clean($this->input->post('driver_mobile'));
                $total_seat_capacity = $this->security->xss_clean($this->input->post('total_seat_capacity'));



                $busInfo = array(
                    'vehicle_number' => $vehicle_number,
                    'insurance_expiry_date' => date('Y-m-d', strtotime($insurance_expiry_date)),
                    'emission_expiry_date' => date('Y-m-d', strtotime($emission_expiry_date)),
                    'permit_date' => date('Y-m-d', strtotime($permit_date)),
                    'tax_expiry_date' => date('Y-m-d', strtotime($tax_expiry_date)),
                    'fitness_certificate_expiry_date' => date('Y-m-d', strtotime($fitness_certificate_expiry_date)),
                    'route' => $route,
                    'driver_name' => $driver_name,
                    'driver_mobile' => $driver_mobile,
                    'total_seat_capacity' => $total_seat_capacity,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                $result = $this->transport->addNewBus($busInfo);
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Bus Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Bus Info Add failed');
                }
                redirect('viewBusListing');
            }
        }
    }

    public function editBus($row_id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('viewBusListing');
            }
            $data['busInfo'] = $this->transport->getBusInfoById($row_id);
            $data['tyreInfo'] = $this->transport->getAllTyreInfo($row_id);
            $data['spareInfo'] = $this->transport->getAllSpareInfo($row_id);
            $data['serviceInfo'] = $this->transport->getAllserviceInfo($row_id);
            $data['fuelInfo'] = $this->transport->getAllFuelInfo($row_id);
            $data['tripInfo'] = $this->transport->getAllTripInfo($row_id);
            $data['routeInfo'] = $this->transport->getRouteInfo();
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Edit Bus Info';
            $this->loadViews("transport/editBus", $this->global, $data, null);
        }
    }

    public function updateBus()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('vehicle_number', 'Vehicle Number', 'trim|required');
            $this->form_validation->set_rules('insurance_expiry_date', 'Insurance Expiry Date', 'trim|required');
            $this->form_validation->set_rules('route', 'Route', 'trim|required');
            $this->form_validation->set_rules('driver_name', 'Driver Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('driver_mobile', 'Driver Mobile', 'required|numeric|min_length[10]');
            $this->form_validation->set_rules('total_seat_capacity', 'Total Seat Capacity', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->editBus();
            } else {

                $vehicle_number = $this->security->xss_clean($this->input->post('vehicle_number'));
                $insurance_expiry_date = $this->security->xss_clean($this->input->post('insurance_expiry_date'));
                $emission_expiry_date = $this->security->xss_clean($this->input->post('emission_expiry_date'));
                $permit_date = $this->security->xss_clean($this->input->post('permit_date'));
                $tax_expiry_date = $this->security->xss_clean($this->input->post('tax_expiry_date'));
                $fitness_certificate_expiry_date = $this->security->xss_clean($this->input->post('fitness_certificate_expiry_date'));
                $route = $this->security->xss_clean($this->input->post('route'));
                $driver_name = $this->security->xss_clean($this->input->post('driver_name'));
                $driver_mobile = $this->security->xss_clean($this->input->post('driver_mobile'));
                $total_seat_capacity = $this->security->xss_clean($this->input->post('total_seat_capacity'));

                $busInfo = array(
                    'vehicle_number' => $vehicle_number,
                    'insurance_expiry_date' => date('Y-m-d', strtotime($insurance_expiry_date)),
                    'emission_expiry_date' => date('Y-m-d', strtotime($emission_expiry_date)),
                    'permit_date' => date('Y-m-d', strtotime($permit_date)),
                    'tax_expiry_date' => date('Y-m-d', strtotime($tax_expiry_date)),
                    'fitness_certificate_expiry_date' => date('Y-m-d', strtotime($fitness_certificate_expiry_date)),
                    'route' => $route,
                    'driver_name' => $driver_name,
                    'driver_mobile' => $driver_mobile,
                    'total_seat_capacity' => $total_seat_capacity,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
                $return_id = $this->transport->updateBus($busInfo, $row_id);

                if ($return_id) {
                    $this->session->set_flashdata('success', 'Bus Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Bus Info Update failed');
                }
                redirect('editBus/' . $row_id);
            }
        }
    }

    public function addTyreInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('purchase_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('kilometer_driven', 'Kilometer Driven', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewBusListing();
            } else {
                $purchase_date = $this->security->xss_clean($this->input->post('purchase_date'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $kilometer_driven = $this->security->xss_clean($this->input->post('kilometer_driven'));
                $comments = $this->security->xss_clean($this->input->post('comments'));
                $tyre_type = $this->security->xss_clean($this->input->post('tyre_type'));
                $tyreInfo = array(
                    'bus_relation_row_id' => $row_id,
                    'purchase_date' => date('Y-m-d', strtotime($purchase_date)),
                    'kilometer_driven' => $kilometer_driven,
                    'amount' => $amount,
                    'comments' => $comments,
                    'tyre_type' => $tyre_type,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                $result = $this->transport->addNewTyre($tyreInfo);
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Tyre Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Tyre Info Add failed');
                }
                redirect('editBus/' . $row_id);
            }
        }
    }


    public function addSpareInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
          //  $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'trim|required');
            $this->form_validation->set_rules('spare_name', 'Spare Name', 'trim|required');
            $this->form_validation->set_rules('kilometer_driven', 'Kilometer Driven', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewBusListing();
            } else {
                $purchase_date = $this->security->xss_clean($this->input->post('purchase_date'));
                $spare_name = $this->security->xss_clean($this->input->post('spare_name'));
                $kilometer_driven = $this->security->xss_clean($this->input->post('kilometer_driven'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $comments = $this->security->xss_clean($this->input->post('comments'));

                $spareInfo = array(
                    'bus_relation_row_id' => $row_id,
                    'purchase_date' => date('Y-m-d', strtotime($purchase_date)),
                    'spare_name' => $spare_name,
                    'kilometer_driven' => $kilometer_driven,
                    'amount' => $amount,
                    'comments' => $comments,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                $result = $this->transport->addNewSpare($spareInfo);
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Spare Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Spare Info Add failed');
                }
                redirect('editBus/' . $row_id);
            }
        }
    }

    public function addServiceInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('service_date', 'Service Date', 'trim|required');
            $this->form_validation->set_rules('next_service_kilometer', 'Next Service Kilometer ', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewBusListing();
            } else {
                $service_date = $this->security->xss_clean($this->input->post('service_date'));
                $spare_name = $this->security->xss_clean($this->input->post('spare_name'));
                $next_service_kilometer = $this->security->xss_clean($this->input->post('next_service_kilometer'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $comments = $this->security->xss_clean($this->input->post('comments'));

                $serviceInfo = array(
                    'bus_relation_row_id' => $row_id,
                    'service_date' => date('Y-m-d', strtotime($service_date)),
                    'next_service_kilometer' => $next_service_kilometer,
                    'amount' => $amount,
                    'comments' => $comments,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                $result = $this->transport->addNewService($serviceInfo);
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Service Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Service Info Add failed');
                }
                redirect('editBus/' . $row_id);
            }
        }
    }

    public function addFuelInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('fuel_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('bill_number', 'Bill Number ', 'trim|required');
            $this->form_validation->set_rules('liter', 'Liter', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('liter_per_rate', 'Liter/Rate', 'trim|required');
            $this->form_validation->set_rules('fuel_kilometer', 'Kilometer Driven', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewBusListing();
            } else {
                $fuel_date = $this->security->xss_clean($this->input->post('fuel_date'));
                $bill_number = $this->security->xss_clean($this->input->post('bill_number'));
                $liter = $this->security->xss_clean($this->input->post('liter'));
                $liter_per_rate = $this->security->xss_clean($this->input->post('liter_per_rate'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $fuel_kilometer = $this->security->xss_clean($this->input->post('fuel_kilometer'));

                $fuelInfo = array(
                    'bus_relation_row_id' => $row_id,
                    'fuel_date' => date('Y-m-d', strtotime($fuel_date)),
                    'bill_number' => $bill_number,
                    'liter' => $liter,
                    'liter_per_rate' => $liter_per_rate,
                    'amount' => $amount,
                    'fuel_kilometer' => $fuel_kilometer,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                $result = $this->transport->addNewFuelInfo($fuelInfo);
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Fuel Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Fuel Info Add failed');
                }
                redirect('editBus/' . $row_id);
            }
        }
    }

    public function addTripInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('trip_date', 'Trip Date', 'trim|required');
            $this->form_validation->set_rules('start_meter', 'Start meter', 'trim|required');
            $this->form_validation->set_rules('end_meter', 'End Driven', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewBusListing();
            } else {
                $trip_date = $this->security->xss_clean($this->input->post('trip_date'));
                $start_meter = $this->security->xss_clean($this->input->post('start_meter'));
                $end_meter = $this->security->xss_clean($this->input->post('end_meter'));
                $comments = $this->security->xss_clean($this->input->post('comments'));

                $tripInfo = array(
                    'bus_relation_row_id' => $row_id,
                    'trip_date' => date('Y-m-d', strtotime($trip_date)),
                    'start_meter' => $start_meter,
                    'end_meter' => $end_meter,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                $result = $this->transport->addNewTrip($tripInfo);
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Trip Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Trip Info Add failed');
                }
                redirect('editBus/' . $row_id);
            }
        }
    }


    public function deleteBus()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $busInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateBus($busInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    public function deleteTyre()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $tyreInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateTyre($tyreInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    public function deleteSpare()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $spareInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateSpare($spareInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    public function deleteService()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $serviceInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateService($serviceInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    public function deleteFuel()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $fuelInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateFuel($fuelInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    public function deleteTrip()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $tripInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateTrip($tripInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    //Student Transport Detail
    function viewStudentTransportListing()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $receipt_no  = $this->security->xss_clean($this->input->post('receipt_no'));
            $student_id  = $this->security->xss_clean($this->input->post('student_id'));
            $by_name  = $this->security->xss_clean($this->input->post('by_name'));
            $bus_number = $this->security->xss_clean($this->input->post('bus_number'));
            $bus_fees = $this->security->xss_clean($this->input->post('bus_fees'));
            $route_from = $this->security->xss_clean($this->input->post('route_from'));
            $route_to = $this->security->xss_clean($this->input->post('route_to'));
            $payment_date = $this->security->xss_clean($this->input->post('payment_date'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $from_date = $this->security->xss_clean($this->input->post('date_from'));
            $to_date = $this->security->xss_clean($this->input->post('date_to'));
            $year = $this->security->xss_clean($this->input->post('year'));

            $data['receipt_no'] = $receipt_no;
            $data['student_id'] = $student_id;
            $data['by_name'] = $by_name;
            $data['bus_number'] = $bus_number;
            $data['bus_fees'] = $bus_fees;
            $data['route_from'] = $route_from;
            $data['route_to'] = $route_to;
            $data['payment_type'] = $payment_type;
            $data['year'] = $year;
        
            $filter['receipt_no'] = $receipt_no;
            $filter['student_id'] = $student_id;
            $filter['by_name'] = $by_name;
            $filter['bus_number'] = $bus_number;
            $filter['bus_fees'] = $bus_fees;
            $filter['route_from'] = $route_from;
            $filter['route_to'] = $route_to;
            $filter['payment_type'] = $payment_type;
            $filter['by_year'] = $year;
           

            if (!empty($payment_date)) {
                $filter['payment_date'] = date('Y-m-d', strtotime($payment_date));
                $data['payment_date'] = date('d-m-Y', strtotime($payment_date));
            } else {
                $data['payment_date'] = '';
            }

            if (!empty($from_date)) {
                $filter['date_from'] = date('Y-m', strtotime($from_date));
                $data['date_from'] = date('m-Y', strtotime($from_date));
            } else {
                $data['date_from'] = '';
            }

            if (!empty($to_date)) {
                $filter['date_to'] = date('Y-m', strtotime($to_date));
                $data['date_to'] = date('m-Y', strtotime($to_date));
            } else {
                $data['date_to'] = '';
            }

            $this->load->library('pagination');
            $count = $this->transport->getAllStudentTransportCount($filter);
            $returns = $this->paginationCompress("viewStudentTransportListing/", $count, 100);
            $data['totalStudentTransportCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentTransportInfo'] = $this->transport->getAllStudentTransportInfo($filter, $returns["page"], $returns["segment"]);
            $data['studentInfo']  = $this->transport->getStudentId();
            $data['busInfo']  = $this->transport->getVehicleNumber();
            $data['settingInfo'] = $this->transport->getTransportNameInfo();
            $data['routeInfo'] = $this->transport->getRouteInfo();
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Student Bus Details';
            $this->loadViews("transport/studentBusDetail.php", $this->global, $data, NULL);
        }
    }

    public function addNewStudentTransportInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $data['studentInfo']  = $this->transport->getStudentId();
            $data['busInfo']  = $this->transport->getVehicleNumber();
            $data['settingInfo'] = $this->transport->getTransportNameInfo();
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Add New Bus';
            $this->loadViews("transport/addNewStudentBus", $this->global, $data, null);
        }
    }

    public function addNewStudentTransport()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('student_id', 'Student Id', 'trim|required');
            $this->form_validation->set_rules('bus_number', 'Vehicle Number', 'trim|required');
            $this->form_validation->set_rules('bus_fees', 'Bus Fees', 'trim|required');
            $this->form_validation->set_rules('route_from', 'Route From', 'trim|required');
            $this->form_validation->set_rules('route_to', 'Route To', 'trim|required');
            $this->form_validation->set_rules('from_date', 'Date From', 'trim|required');
            $this->form_validation->set_rules('from_date', 'Date To', 'trim|required');
            $this->form_validation->set_rules('payment_date', 'Payment date', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->addNewStudentTransportInfo();
            } else {
                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $bus_number = $this->security->xss_clean($this->input->post('bus_number'));
                $bus_fees = $this->security->xss_clean($this->input->post('bus_fees'));
                $route_from = $this->security->xss_clean($this->input->post('route_from'));
                $route_to = $this->security->xss_clean($this->input->post('route_to'));
                $from_date = $this->security->xss_clean($this->input->post('from_date'));
                $to_date = $this->security->xss_clean($this->input->post('to_date'));
                $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
                $payment_date = $this->security->xss_clean($this->input->post('payment_date'));
                $challan_number = $this->security->xss_clean($this->input->post('challan_number'));
                $challan_date = $this->security->xss_clean($this->input->post('challan_date'));

                $check_number = $this->security->xss_clean($this->input->post('check_number'));
                $check_date = $this->security->xss_clean($this->input->post('check_date'));
                $check_bank_name = $this->security->xss_clean($this->input->post('check_bank_name'));

                $neft_number = $this->security->xss_clean($this->input->post('neft_number'));
                $neft_date = $this->security->xss_clean($this->input->post('neft_date'));
                $neft_bank_name = $this->security->xss_clean($this->input->post('neft_bank_name'));

                $transaction_number = $this->security->xss_clean($this->input->post('transaction_number'));
                $transaction_date = $this->security->xss_clean($this->input->post('transaction_date'));
                $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
                $intake_year = $this->security->xss_clean($this->input->post('intake_year'));

                $transportRate = $this->transport->getTransportRateInfoById($bus_fees);

                if ($payment_type == 'CASH') {
                    $payment_status = 1;
                } else {
                    $payment_status = 1;
                }

                $studentTransportInfo = array(
                    'student_id' => $student_id,
                    'bus_number' => $bus_number,
                    'bus_fees' => $bus_fees,
                    'route_from' => $route_from,
                    'route_to' => $route_to,
                    'payment_date' => date('Y-m-d', strtotime($payment_date)),
                    'from_date' => date('Y-m-d', strtotime($from_date)),
                    'to_date' => date('Y-m-d', strtotime($to_date)),
                    'payment_type' => $payment_type,
                    'intake_year' => $intake_year,
                    // 'payment_status' => $payment_status,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );

                $result = $this->transport->addNewStudentTransport($studentTransportInfo);

                if ($result > 0) {
                    $studentTransportInfo['payment_status'] = $payment_status;
                    $this->transport->updateStudentTransportInfo($studentTransportInfo, $result);


                    if ($payment_type == 'CHEQUE') {
                        $checkInfo = array(
                            'std_bus_row_id' => $result,
                            'check_number' => $check_number,
                            'check_date' => date('Y-m-d', strtotime($check_date)),
                            'bank_name' => $check_bank_name,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s')
                        );
                        $this->transport->addTransportChequeInfo($checkInfo);
                    } else if ($payment_type == 'CHALLAN') {
                        $challanInfo = array(
                            'std_bus_row_id' => $result,
                            'challan_number ' => $challan_number,
                            'challan_date' => date('Y-m-d', strtotime($challan_date)),
                            'challan_bank' => $bank_name,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s')
                        );
                        $this->transport->addChallanInfo($challanInfo);
                    } else if ($payment_type == 'CARD') {
                        $cardInfo = array(
                            'std_bus_row_id' => $result,
                            'transaction_number' => $transaction_number,
                            'bank_name' => $bank_name,
                            'transaction_date' => date('Y-m-d', strtotime($transaction_date)),
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s')
                        );
                        $this->transport->addTransportCardInfo($cardInfo);
                    }
                }

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'New Student Bus Info Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Student Bus Info Add failed');
                }
                redirect('addNewStudentTransport');
            }
        }
    }

    public function editStudentTransport($row_id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('viewStudentTransportListing');
            }
            $data['busInfo']  = $this->transport->getVehicleNumber();
            $data['studentInfo']  = $this->transport->getStudentId();
            $data['settingInfo'] = $this->transport->getTransportNameInfo();
            $data['studentTransportInfo'] = $this->transport->getStudentTransportInfoById($row_id);
            $data['neftInfo'] = $this->transport->getTransportneftInfo($row_id);
            $data['chequeInfo'] = $this->transport->getTransportChequeInfo($row_id);
            $data['cardInfo'] = $this->transport->getTransportCardInfo($row_id);
            $data['challanInfo'] = $this->transport->getChallanInfo($row_id);
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Edit Student Bus Info';
            $this->loadViews("transport/editStudentBus", $this->global, $data, null);
        }
    }

    public function updateStudentTransportInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('student_id', 'Student Id', 'trim|required');
            $this->form_validation->set_rules('bus_number', 'Vehicle Number', 'trim|required');
            $this->form_validation->set_rules('bus_fees', 'Bus Fees', 'trim|required');
            $this->form_validation->set_rules('route_from', 'Route From', 'trim|required');
            $this->form_validation->set_rules('route_to', 'Route To', 'trim|required');
            $this->form_validation->set_rules('from_date', 'Date From', 'trim|required');
            $this->form_validation->set_rules('to_date', 'Date To', 'trim|required');
            $this->form_validation->set_rules('payment_date', 'Payment date', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                redirect('editStudentTransport/' . $row_id);
            } else {

                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $bus_number = $this->security->xss_clean($this->input->post('bus_number'));
                $bus_fees = $this->security->xss_clean($this->input->post('bus_fees'));
                $route_from = $this->security->xss_clean($this->input->post('route_from'));
                $route_to = $this->security->xss_clean($this->input->post('route_to'));
                $from_date = $this->security->xss_clean($this->input->post('from_date'));
                $to_date = $this->security->xss_clean($this->input->post('to_date'));
                $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
                $payment_date = $this->security->xss_clean($this->input->post('payment_date'));
                $challan_number = $this->security->xss_clean($this->input->post('challan_number'));
                $challan_date = $this->security->xss_clean($this->input->post('challan_date'));

                $check_number = $this->security->xss_clean($this->input->post('check_number'));
                $check_date = $this->security->xss_clean($this->input->post('check_date'));
                $check_bank_name = $this->security->xss_clean($this->input->post('check_bank_name'));

                $neft_number = $this->security->xss_clean($this->input->post('neft_number'));
                $neft_date = $this->security->xss_clean($this->input->post('neft_date'));
                $challan_bank_name = $this->security->xss_clean($this->input->post('challan_bank_name'));

                $transaction_number = $this->security->xss_clean($this->input->post('transaction_number'));
                $transaction_date = $this->security->xss_clean($this->input->post('transaction_date'));
                $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
                $intake_year = $this->security->xss_clean($this->input->post('intake_year'));

                $transportRate = $this->transport->getTransportRateInfoById($bus_fees);

                if ($payment_type == 'CASH') {
                    $payment_status = 1;
                } else {
                    $payment_status = 1;
                }

                $studentTransportInfo = array(
                    'student_id' => $student_id,
                    'bus_number' => $bus_number,
                    'bus_fees' => $bus_fees,
                    'route_from' => $route_from,
                    'route_to' => $route_to,
                    'payment_type' => $payment_type,
                    'intake_year' => $intake_year,
                    'from_date' => date('Y-m-d', strtotime($from_date)),
                    'payment_date' => date('Y-m-d', strtotime($payment_date)),
                    'to_date' => date('Y-m-d', strtotime($to_date)),
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                );

                if ($payment_type == 'CHEQUE') {
                    $checkInfo = array(
                        'std_bus_row_id' => $row_id,
                        'check_number' => $check_number,
                        'check_date' => date('Y-m-d', strtotime($check_date)),
                        'bank_name' => $check_bank_name,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );

                    $neftInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );

                    $cardInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );

                    $chequeInfoExists = $this->transport->checkTransportChequeInfo($row_id);
                    $neftInfoExists = $this->transport->checkTransportneftInfo($row_id);
                    $cardInfoExists = $this->transport->checkTransportCardInfo($row_id);

                    if ($chequeInfoExists > 0) {
                        $this->transport->updateTransportChequeInfo($checkInfo, $row_id);
                    } else {
                        $this->transport->addTransportChequeInfo($checkInfo);
                    }

                    if ($neftInfoExists > 0) {
                        $this->transport->updateTransportNeftInfo($neftInfo, $row_id);
                    }

                    if ($cardInfoExists > 0) {
                        $this->transport->updateTransportCardInfo($cardInfo, $row_id);
                    }
                } else if ($payment_type == 'CHALLAN') {
                    $challanInfo = array(
                        'std_bus_row_id' => $row_id,
                        'challan_number ' => $challan_number,
                        'challan_bank' => $challan_bank_name,
                        'challan_date' => date('Y-m-d', strtotime($challan_date)),
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );

                    $neftInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );

                    $checkInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $cardInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );

                    $challanInfoExists = $this->transport->getChallanInfo($row_id);
                    $neftInfoExists = $this->transport->checkTransportneftInfo($row_id);
                    $chequeInfoExists = $this->transport->checkTransportChequeInfo($row_id);
                    $cardInfoExists = $this->transport->checkTransportCardInfo($row_id);
                    if ($challanInfoExists > 0) {
                        $this->transport->updateTransportChallanInfo($challanInfo, $row_id);
                    } else {
                        $this->transport->addChallanInfo($challanInfo);
                    }

                    if ($neftInfoExists > 0) {
                        $this->transport->updateTransportNeftInfo($neftInfo, $row_id);
                    }

                    if ($chequeInfoExists > 0) {
                        $this->transport->updateTransportChequeInfo($checkInfo, $row_id);
                    }

                    if ($cardInfoExists > 0) {
                        $this->transport->updateTransportCardInfo($cardInfo, $row_id);
                    }
                } else if ($payment_type == 'CARD') {
                    $cardInfo = array(
                        'std_bus_row_id' => $row_id,
                        'transaction_number ' => $transaction_number,
                        'transaction_date' => date('Y-m-d', strtotime($transaction_date)),
                        'bank_name' => $bank_name,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );

                    $checkInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $neftInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );

                    $cardInfoExists = $this->transport->checkTransportCardInfo($row_id);
                    $neftInfoExists = $this->transport->checkTransportneftInfo($row_id);
                    $chequeInfoExists = $this->transport->checkTransportChequeInfo($row_id);
                    if ($cardInfoExists > 0) {
                        $this->transport->updateTransportCardInfo($cardInfo, $row_id);
                    } else {
                        $this->transport->addTransportCardInfo($cardInfo);
                    }

                    if ($neftInfoExists > 0) {
                        $this->transport->updateTransportNeftInfo($neftInfo, $row_id);
                    }
                    if ($chequeInfoExists > 0) {
                        $this->transport->updateTransportCardInfo($cardInfo, $row_id);
                    }
                } else {
                    $return_id = $this->transport->updateStudentTransportInfo($studentTransportInfo, $row_id);
                    $checkInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $neftInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );

                    $cardInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
                    $challanInfo = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
                    $challanInfoExists = $this->transport->getChallanInfo($row_id);
                    $cardInfoExists = $this->transport->checkTransportCardInfo($row_id);
                    $neftInfoExists = $this->transport->checkTransportneftInfo($row_id);
                    $chequeInfoExists = $this->transport->checkTransportChequeInfo($row_id);
                    if ($chequeInfoExists > 0) {
                        $this->transport->updateTransportChequeInfo($checkInfo, $row_id);
                    }
                    if ($neftInfoExists > 0) {
                        $this->transport->updateTransportNeftInfo($neftInfo, $row_id);
                    }
                    if ($cardInfoExists > 0) {
                        $this->transport->updateTransportCardInfo($cardInfo, $row_id);
                    }
                    if ($challanInfoExists > 0) {
                        $this->transport->updateTransportChallanInfo($challanInfo, $row_id);
                    }
                }
                if ($payment_type == 'CHEQUE' || $payment_type == 'CHALLAN' || $payment_type == 'CARD') {
                    $return_id = $this->transport->updateStudentTransportInfo($studentTransportInfo, $row_id);
                }


                if ($return_id > 0) {
                    $studentTransportInfo['payment_status'] = $payment_status;
                    $this->transport->updateStudentTransportInfo($studentTransportInfo, $result);
                }

                if ($return_id) {
                    $this->session->set_flashdata('success', 'Student Bus Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Student Bus Info Update failed');
                }
                redirect('editStudentTransport/' . $row_id);
            }
        }
    }

    public function deleteStudentTransport()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $studentTransportInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->updateStudentTransportInfo($studentTransportInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
                $transportExpenseInfo = array('is_deleted' => 1, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
                // $result = $this->wallet->deleteStudentTransportExpenseInfo($transportExpenseInfo, $row_id);
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    // Transport settings
    public function viewTransportSettings()
    {

        $data['settingInfo'] = $this->transport->getTransportNameInfo();
        $this->global['pageTitle'] = '' . TAB_TITLE . ' : Transport Settings';
        $this->loadViews("transport/transportSettings", $this->global, $data, null);
    }

    //add transport name info 

    function addTransportName()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $name = $this->security->xss_clean($this->input->post('name'));
            $rate = $this->security->xss_clean($this->input->post('rate'));
            $bus_no = $this->security->xss_clean($this->input->post('bus_no'));
            $transportInfo = array(
                'name' => $name,
                'rate' => $rate,
                'bus_no' => $bus_no,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s')
            );
            $result = $this->transport->addTransportName($transportInfo);
            if ($result > 0) {
                $this->session->set_flashdata('success', 'New Transport Info created successfully');
            } else {
                $this->session->set_flashdata('error', 'Transport Info creation failed');
            }
            redirect('viewSettings');
        }
    }

    public function editTransportInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $transport_name = $this->security->xss_clean($this->input->post('transport_name'));
            $fee_rate = $this->security->xss_clean($this->input->post('fee_rate'));
            $bus_number = $this->security->xss_clean($this->input->post('bus_number'));
           
            $transportFee = array(
                    'name' => $transport_name,
                    'rate' => $fee_rate,
                    'bus_no' => $bus_number,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));
    
            $result = $this->transport->updateTransportInfo($transportFee,$row_id);
                    
            if($result > 0){
                $this->session->set_flashdata('success', 'Transport Fee Updated Successfully');
            }else{
                $this->session->set_flashdata('error', 'Transport Fee Update Failed!');
            }
            redirect('viewSettings');

        }
    }

    public function deleteTransportName()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $transportInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->transport->deleteTransportName($transportInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }



    public function printStudentTransportBill($row_id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('viewStudentTransportListing');
            }
            error_reporting(0);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font' => 'timesnewroman', 'format' => 'A4-L']);
            $mpdf->AddPage('L', '', '', '', '', 7, 7, 25, 15, 8, 8);
            $mpdf->SetTitle('Transport Receipt');
            $data['receipt_title_mgmt'] = "HOLY ANGELS SCHOOL";
            $data['studentTransportInfo'] = $this->transport->getStudentTransportInfoById($row_id);

            $data['transport_rate'] = $data['studentTransportInfo']->bus_fees;
            $data['transport_rate_words'] = $this->getIndianCurrency(floatval($data['transport_rate']));
            $data['name_count'] = 0;
            $html_student_copy = $this->load->view('transport/printStudentTransportBill',$data,true);
            $data['name_count'] = 1;
            $html_office_copy = $this->load->view('transport/printStudentTransportBill',$data,true);
            $data['name_count'] = 2;
            $html_bus_copy = $this->load->view('transport/printStudentTransportBill',$data,true);
        
            $mpdf->WriteHTML('<columns column-count="3" vAlign="J" column-gap="10" />');
            $mpdf->WriteHTML($html_student_copy);
            $mpdf->WriteHTML($html_office_copy);
            $mpdf->WriteHTML($html_bus_copy);

            $mpdf->Output('Transport_Receipt.pdf', 'I');
        }
    }

    function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public function transFeePayNow(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['fee_pending_status'] = false;
            $data['studentInfo'] = $this->student->getCurrentStudentInfoForTrans();
            $data['studentInfo22'] = $this->student->getStudentPreviousPendingAmt();
          
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
            $this->loadViews("transport/busPaymentPortal", $this->global, $data, null);
        }
    }
        
    public function getStudentTransFeePaymentInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $year = $this->security->xss_clean($this->input->post('year'));
            if($year == '2022'){
                $student_row_id = $this->security->xss_clean($this->input->post('student_row_id22'));
            }else{
                $student_row_id = $this->security->xss_clean($this->input->post('student_row_id23'));
            }
        
            if(empty($student_row_id)){
                $student_row_id = $_SESSION['studentRowID'];
                $year = $_SESSION['year'];
            }
            $data['studentInfo'] = $this->student->getCurrentStudentInfoForTrans();
            $data['studentInfo22'] = $this->student->getStudentPreviousPendingAmt();
            if(!empty($student_row_id)){

                $data['studentInfo'] = $this->student->getCurrentStudentInfoForTrans(); 
                $data['total_fee_pending'] = 0.00;
                $data['total_fee_paid'] = 0.00;
                $studentData = $this->student->getStudentsInfoById($student_row_id);
                $total_fee = $data['total_fee'] = $studentData->rate;
                if($year == CURRENT_YEAR){
                    $total_fee_amount = $studentData->rate;
                }else{
                    $previousbal = $this->transport->getStdPreviousBalByID($student_row_id);
                    $total_fee_amount = $previousbal->amount;
                }
               
                $feePaidInfo = $this->transport->getTransportTotalPaidAmount($student_row_id,$year);
                if(!empty($feePaidInfo->paid_amount)){
                    $total_fee_amount -= $feePaidInfo->paid_amount;
                }
                $feeConcession = $this->transport->getFeeConcessionInfo($student_row_id,$year); 
                if(!empty($feeConcession)){
                    $total_fee_amount -= $feeConcession->fee_amt;
                    $data['feeConcession'] = $feeConcession;
                }
                $data['stdFeePaymentInfo'] = $this->transport->getStudentOverallTransFeePaymentInfo($student_row_id,$year);
                $data['feePaidInfo'] = $feePaidInfo;
                $data['studentData'] = $studentData;
                $data['previousbal'] = $previousbal;
               
               
                $data['fee_amount'] = $total_fee_amount;
                $data['year'] = $year;
                if($total_fee_amount == 0 || $total_fee_amount < 0){
                    $data['installment_amt'] = 0;
                    $data['fee_pending_status'] = false;
                    $this->session->set_flashdata('success','Selected student fee is already paid!');
                //  $data['feeInfo'] = $this->admission->getFeePaidInfo($studentInfo->application_number);
                }else{
                    $data['fee_pending_status'] = true;
                }
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Payment Portal' ;
                $this->loadViews("transport/busPaymentPortal", $this->global, $data, null);
            }else{
                redirect('transFeePayNow');
            }
            
        }
    }



    public function addTransFeePaymentInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {  
            $filter = array();
            $student_row_id = $this->security->xss_clean($this->input->post('student_row_id'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $paid_fee_amount = $this->security->xss_clean($this->input->post('paid_fee_amount'));
            $upi_ref_no = $this->security->xss_clean($this->input->post('upi_ref_no'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
    
            $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
            $dd_bank_name = $this->security->xss_clean($this->input->post('dd_bank_name'));
    
            $tran_number = $this->security->xss_clean($this->input->post('tran_number'));
            $tran_date = $this->security->xss_clean($this->input->post('tran_date'));
            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));

            $card_tran_number = $this->security->xss_clean($this->input->post('card_tran_number'));
            $card_tran_date = $this->security->xss_clean($this->input->post('card_tran_date'));
            $card_bank_name = $this->security->xss_clean($this->input->post('card_bank_name'));
            
            // $payment_option = $this->security->xss_clean($this->input->post('payment_option'));

            $payment_date = $this->security->xss_clean($this->input->post('payment_date'));
            $from_date = $this->security->xss_clean($this->input->post('month_from'));
   
            $to_date = $this->security->xss_clean($this->input->post('month_to'));
            $month = $this->security->xss_clean($this->input->post('month_diff'));
            $ref_receipt_no = $this->security->xss_clean($this->input->post('receipt_no'));
            $isExist = $this->transport->checkReceiptNoExists($ref_receipt_no,$year);
            if(!empty($isExist)){
                $this->session->set_flashdata('error', 'Receipt No. Already Exists');
                $_SESSION['studentRowID'] = $student_row_id;
                $_SESSION['year'] = $year;
                redirect('getStudentTransFeePaymentInfo');
            }

            

            // $ref_number = $this->security->xss_clean($this->input->post('ref_number'));
            // $neft_date = $this->security->xss_clean($this->input->post('neft_date'));

            if($payment_type == 'DD'){
                $bank_name = $dd_bank_name;
            }else if($payment_type == 'CARD'){
                $tran_number = $card_tran_number;
                $tran_date = $card_tran_date;
                $bank_name = $card_bank_name;
            }

            if(!empty($dd_date)){
                $dd_date = date('Y-m-d',strtotime($dd_date));
            }else{
                $dd_date = '';
            }

            if(!empty($tran_date)){
                $tran_date = date('Y-m-d',strtotime($tran_date));
            }else{
                $tran_date = '';
            }
         
            $studentInfo = $this->student->getStudentsInfoById($student_row_id);
            if($year == CURRENT_YEAR){
                $total_fee = $studentInfo->rate;
                $term_name = $studentInfo->term_name;
            }else{
                $previousbal = $this->transport->getStdPreviousBalByID($student_row_id);
                $total_fee = $previousbal->amount;
                $term_name = $previousbal->term_name;
            }
            $total_fee_pending_to_pay = $total_fee;

            $feePaidInfo = $this->transport->getTransportTotalPaidAmount($student_row_id,$year);
            if(!empty($feePaidInfo->paid_amount)){
                $total_fee_pending_to_pay -= $feePaidInfo->paid_amount;
            }

            // $data['stdFeePaymentInfo'] = $this->transport->getStudentOverallTransFeePaymentInfo($student_row_id,$year);
            
            $pending_fee_balance = $total_fee_pending_to_pay - $paid_fee_amount;
            if($pending_fee_balance <= 0){
                $fee_excess_amount = abs($pending_fee_balance);
                $fee_pending_status = 0;
                $pending_fee_balance = 0;
            }else if($pending_fee_balance > 0){
                $fee_excess_amount = 0;
                $fee_pending_status = 1;
                $pending_fee_balance = $pending_fee_balance;
            }

            //get last recept number
            $receipt_number = $this->transport->getLastReceiptNoFromTransport($year);
            if(empty($receipt_number)){
                     $receipt_number = 0;
            }
            $receipt_number += 1;
            //add 0000 to recept number
            $receipt_no = sprintf('%04d', $receipt_number);
                
            $overallFee = array(
                    'student_id' => $student_row_id,
                    'receipt_no' => $receipt_no,
                    'total_amount' => $total_fee_pending_to_pay,
                    'payment_date' => date('Y-m-d',strtotime($payment_date)),
                    'from_date' => date('Y-m',strtotime($from_date)),
                    'to_date' => date('Y-m',strtotime($to_date)),
                    'term_name' => $term_name,
                    'bus_fees' => $paid_fee_amount,
                    'pending_balance' => $pending_fee_balance,
                    'payment_type' => $payment_type,
                    'transaction_number' => $tran_number,
                    'transaction_date' => $tran_date,
                    'bank_name' => $bank_name,
                    'upi_ref_no' =>$upi_ref_no,
                    'dd_number' => $dd_number,
                    'dd_date' => $dd_date,
                    'intake_year' => $year,
                    'month' => $month,
                    'ref_receipt_no' => $ref_receipt_no,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s'));
    
            $receipt_number = $this->transport->addNewStudentTransport($overallFee);
            if($year == CURRENT_YEAR){
                $start    = new DateTime($from_date);
                $start->modify('first day of this month');
                $end      = new DateTime($to_date);
                $end->modify('first day of next month');
                $interval = DateInterval::createFromDateString('1 month');
                $period   = new DatePeriod($start, $interval, $end);

                foreach ($period as $dt) {
                    echo $dt->format("Y-m") . "<br>\n";
                    $overallMonth = array(
                        'payment_id' => $receipt_number,
                        'month' => $dt->format("m"),
                        'amount' => $paid_fee_amount / $month);
                        $result = $this->transport->addTransportMonth($overallMonth);
                }
            }     
                
            $data['studentData'] = $studentInfo;
            $_SESSION['studentRowID'] = $student_row_id;
            $_SESSION['year'] = $year;
            if(!empty($receipt_number)){
                $this->session->set_flashdata('success', 'Transport Fee Paid Successfully');
                redirect('getStudentTransFeePaymentInfo');
            }else{
                $this->session->set_flashdata('error', 'Transport Fee Payment Failed!');
                redirect('getStudentTransFeePaymentInfo'); 
            }
        }
    }

    public function deleteFeeReceipt(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $receiptInfo = array('is_deleted' => 1,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->transport->deleteReceipt($row_id, $receiptInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }

    public function getReceipt(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $ref_receipt_no = $this->input->post("reference_receipt_no");
            $year = $this->input->post("year");
            $data['result'] = $this->transport->getCheckReceiptNo($ref_receipt_no,$year);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    function cancelBusListing()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $sat_number = $this->security->xss_clean($this->input->post('sat_number'));
            $std_name = $this->security->xss_clean($this->input->post('std_name'));
            $class = $this->security->xss_clean($this->input->post('class'));
            $route_from = $this->security->xss_clean($this->input->post('route_from'));
            $join_date = $this->security->xss_clean($this->input->post('join_date'));
            $end_date = $this->security->xss_clean($this->input->post('end_date'));

          
            $data['sat_number'] = $sat_number;
            $filter['sat_number'] = $sat_number;
            $data['std_name'] = $std_name;
            $filter['std_name'] = $std_name;
            $data['class'] = $class;
            $filter['class'] = $class;
            $data['route_from'] = $route_from;
            $filter['route_from'] = $route_from;
            $data['route_from'] = $route_from;
            $filter['route_from'] = $route_from;

            if (!empty($join_date)) {
                $filter['join_date'] = date('Y-m-d', strtotime($join_date));
                $data['join_date'] = date('d-m-Y', strtotime($join_date));
            } else {
                $data['join_date'] = '';
            }

            if (!empty($end_date)) {
                $filter['end_date'] = date('Y-m-d', strtotime($end_date));
                $data['end_date'] = date('d-m-Y', strtotime($end_date));
            } else {
                $data['end_date'] = '';
            }
   
            $this->load->library('pagination');
            $count = $this->transport->getAllCancelledBusCount($filter);
            $returns = $this->paginationCompress("cancelBusListing/", $count, 100);
            $data['totalBusCount'] = $count;
            // $data['termInfo'] = $this->student->getTermInfo();
            $data['routeInfo'] = $this->transport->getRouteInfo();

            $data['studentInfo'] = $this->student->getCurrentStudentInfoForTrans();
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['BusInfo'] = $this->transport->getAllCancelledBusInfo($filter, $returns["page"], $returns["segment"]);
            // log_message('debug','routbus'.print_r($data['BusInfo'],true));

            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Bus Details';
            $this->loadViews("transport/cancelBusDetails.php", $this->global, $data, NULL);
        }
    }

    public function updateCancelBus()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
           
                $row_id = $this->security->xss_clean($this->input->post('row_id'));
                $join_date = $this->security->xss_clean($this->input->post('join_date'));
                $end_date = $this->security->xss_clean($this->input->post('end_date'));
                
                    if (!empty($join_date)) {
                        $filter['join_date'] = date('Y-m-d', strtotime($join_date));
                        $data['join_date'] = date('d-m-Y', strtotime($join_date));
                    } else {
                        $data['join_date'] = '';
                    }
                    if (!empty($end_date)) {
                        $filter['end_date'] = date('Y-m-d', strtotime($end_date));
                        $data['end_date'] = date('d-m-Y', strtotime($end_date));
                    } else {
                        $data['end_date'] = '';
                    }

                // log_message('debug','row'.$row_id);
                $busInfo = array(
                    'cancel_bus_status' => 1,
                    'bus_joined_date' => date('Y-m-d',strtotime($join_date)),
                    'bus_end_date' => date('Y-m-d',strtotime($end_date)),
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
                $return_id = $this->student->updateStudentInfo($busInfo, $row_id);

                if ($return_id) {
                    $this->session->set_flashdata('success', 'Cancelled Bus Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Cancelled Bus Info Update failed');
                }
                redirect('cancelBusListing');
            
        }
    }

    public function deleteCancelBus()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
           
            $busInfo = array(
                'cancel_bus_status' => 0,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->student->updateStudentInfo($busInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        }
    }

    public function viewBusFeeConcession(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_id = $this->security->xss_clean($this->input->post('by_id'));
            $admission_no = $this->security->xss_clean($this->input->post('admission_no'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $concession_from = $this->security->xss_clean($this->input->post('concession_from'));
            $concession_to = $this->security->xss_clean($this->input->post('concession_to'));
            $year = $this->security->xss_clean($this->input->post('year'));
            
            $data['by_id'] = $by_id;
            $data['admission_no'] = $admission_no;
            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['year'] = $year;

            $filter['by_id'] = $by_id;
            $filter['admission_no'] = $admission_no;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            $filter['year'] = $year;

            // if(!empty($concession_from)){
            //     $filter['concession_from'] = date('Y-m-d',strtotime($concession_from));
            //     $data['concession_from'] = date('d-m-Y',strtotime($concession_from));
            // }else{
            //     $data['concession_from'] = '';
            // }
            // if(!empty($concession_to)){
            //     $filter['concession_to'] = date('Y-m-d',strtotime($concession_to));
            //     $data['concession_to'] = date('d-m-Y',strtotime($concession_to));
            // }else{
            //     $data['concession_to'] = '';
            // }
            $this->load->library('pagination');
            $count = $this->transport->getFeeConcessionCount($filter);
            $returns = $this->paginationCompress("viewBusFeeConcession/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['concessionInfo'] = $this->transport->getFeeConcessionInfoList($filter);
            $data['studentInfo'] = $this->student->getCurrentStudentInfoForTrans($filter);
            // $data['studentInfo22'] = $this->student->getStudentPreviousPendingAmt();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Concession';
            $this->loadViews("transport/busconcession", $this->global, $data, null);
        }
    }
    public function addBusConcession() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('student_id','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('description','Remarks','trim|required');

            if($this->form_validation->run() == FALSE) {
                $this->viewBusFeeConcession();
            } else {
                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $year = $this->security->xss_clean($this->input->post('con_year'));
                $concession_from = $this->security->xss_clean($this->input->post('concession_from'));
                $concession_to = $this->security->xss_clean($this->input->post('concession_to'));
                // $isExist = $this->transport->checkStudentIdExists($student_id);
                // if(!empty($isExist)){
                //     $this->session->set_flashdata('warning', 'Student Already Exists');
                //     redirect('viewBusFeeConcession');
                // }else{ 
                    $feeInfo = array(
                        'student_id'=>$student_id,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'con_year' => $year,
                        'concession_from'=>date('Y-m-d',strtotime($concession_from)),
                        'concession_to'=>date('Y-m-d',strtotime($concession_to)),
                        'date'=>date('Y-m-d H:i:s'),
                        'approved_status'=>0,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->transport->addConcession($feeInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Scholarship Added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Scholarship');
                    }
                // }
                redirect('viewBusFeeConcession');
                
            }
        }
    }
    
    public function editBusConcession($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewFeeStructure');
            }
            $data['feeInfo'] = $this->transport->getFeeConcessionById($row_id);
            $data['studentInfo'] = $this->student->getstudentInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Concession';
            $this->loadViews("transport/editbusConcession", $this->global, $data, null);
        }
    }

    public function updateBusConcession() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('student_id','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('description','Remarks','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editbusConcession/'.$row_id);
            } else {
                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $year = $this->security->xss_clean($this->input->post('year'));

                    $feeInfo = array(
                        'student_id'=>$student_id,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'con_year' => $year,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->transport->updateConcession($feeInfo,$row_id);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Scholarship Updated successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Update Scholarship');
                    }
                redirect('editBusConcession/'.$row_id);
            }
        }
    }

    
    public function deleteBusConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->transport->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function approveBusConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->transport->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function rejectBusConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 2,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->transport->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}
