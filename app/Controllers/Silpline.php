<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SilplineModel;
use CodeIgniter\HTTP\RequestTrait;
use ResourceBundle;

class Silpline extends ResourceController
{
    use RequestTrait;

    public function index()
    {
        $model = new SilplineModel();
        $data = $model->orderBy('name_id', 'DESC')->findAll();

        // return $this->listpayflex($data);

        return $this->respond($data);
    }

    public function login()
    {
        $model = new SilplineModel();
        $login = [
            "name_id" => $this->request->getVar('name_id'),
            "pass" => $this->request->getVar('pass')
        ];

        $datagroup = $model->groupBy('name_id', 'start_date', 'branch_name');

        $checks = $datagroup->where($login)->findAll();

        if (count($checks) != 0) {
            foreach ($checks as $row) {
                $name_id = $row['name_id'];
                $name = $row['emp_name'];
                $posbranch_name = $row['posbranch_name'];
                $branch_name = $row['branch_name'];
            }
            // $response = [
            //     'name_id' => $name_id,
            //     'name' => $name,
            //     'posbranch_name' => $posbranch_name,
            //     'branch_name' =>  $branch_name
            // ];
            $response = [
                'name_id' => $name_id,
                'name' => $name,
                'posbranch_name' => $posbranch_name,
                'branch_name' =>  $branch_name,
                'satatus' => "pass"
            ];
            return $this->respond($response);
        } else {
            $response = [

                'satatus' => "not_pass"
            ];
            return $this->respond($response);
        }
    }

    public function getSilp($nameid = null)
    {
        $model = new SilplineModel();
        $datagroup = $model->groupBy('paynum_month');

        $data['tb_silp_line']  = $datagroup->where('name_id', $nameid)->findAll();

        if ($data != null) {
            foreach ($data['tb_silp_line'] as $key => $product) {
                // $messages[] = array(
                //     'name' => $data['tb_silp_line'][$key]['name_id'],
                // );
                $pay_month[] = [
                    "type" => "button",
                    "style" => "link",
                    "height" => "sm",
                    "action" => [
                        "type" => "message",
                        "label" => $data['tb_silp_line'][$key]['paynum_month'],
                        "text" => $data['tb_silp_line'][$key]['paynum_month']
                    ]
                ];

                $messages = [
                    "response_type" => "object",
                    "line_payload" => [
                        [
                            "type" => "flex",
                            "altText" => "เลือกงวดการจ่าย",
                            "contents" => [
                                "type" => "bubble",
                                "hero" => [
                                    "type" => "image",
                                    "url" => "https://989job.co/imgposjob/middle.jpg",
                                    "size" => "full",
                                    "aspectRatio" => "20:13",
                                    "aspectMode" => "cover"
                                ],
                                "body" => [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => [
                                        [
                                            "type" => "text",
                                            "text" => "E-PaySilp",
                                            "weight" => "bold",
                                            "size" => "xl",
                                            "position" => "relative",
                                            "align" => "start"
                                        ],
                                        [
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "margin" => "lg",
                                            "spacing" => "sm",
                                            "contents" => [
                                                [
                                                    "type" => "text",
                                                    "text" => "เลือกเดือนที่คุณต้องการ"
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                "footer" => [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "spacing" => "sm",
                                    "contents" =>  $pay_month
                                ]
                            ]
                        ]
                    ]

                ];
            }

            return $this->respond($messages);
        } else {
            return $this->failNotFound('No Product Found');
        }
      

    }

    public function paynum($nameid = null)
    {
        $model = new SilplineModel();

        $var = [
            'paynum_month' => $this->request->getVar('pay_num'),
            'name_id' => $nameid
        ];

        // return $this->respond($data);

        $data['tb_silp_line'] = $model->where($var)->findAll();
        if ($data != null) {
            foreach ($data['tb_silp_line'] as $key => $product) {
                // $messages[] = array(
                //     'name' => $data['tb_silp_line'][$key]['name_id'],
                // );
                $carousel_pay[] = [
                        "type" => "bubble",
                        "hero" => [
                          "type" => "image",
                          "url" => "https://989job.co/imgposjob/it.jpg",
                          "size" => "full",
                          "aspectRatio" => "20:13",
                          "aspectMode" => "cover"
                        ],
                        "body" => [
                          "type" => "box",
                          "layout" => "vertical",
                          "contents" => [
                            [
                              "type" => "text",
                              "text" => "สลิปเงินเดือนของคุณ",
                              "weight" => "bold",
                              "size" => "xl"
                            ],
                            [
                              "type" => "box",
                              "layout" => "vertical",
                              "margin" => "lg",
                              "spacing" => "sm",
                              "contents" => [
                               [ 
                                  "type" => "box",
                                  "layout" => "baseline",
                                  "spacing" => "sm",
                                  "contents" => [
                                    [
                                      "type" => "text",
                                      "text" => "รหัสพนักงาน :",
                                      "color" => "#aaaaaa",
                                      "size" => "sm",
                                      "flex" => 3
                                    ],
                                    [
                                      "type" => "text",
                                      "wrap" => true,
                                      "color" => "#666666",
                                      "size" => "sm",
                                      "flex" => 5,
                                      "text" => $data['tb_silp_line'][$key]['name_id']
                                    ]
                                  ]
                                ],
                                [
                                  "type" => "box",
                                  "layout" => "baseline",
                                  "spacing" => "sm",
                                  "contents" => [
                                    [
                                      "type" => "text",
                                      "text" => "ชื่อ - นามสกุล :",
                                      "color" => "#aaaaaa",
                                      "size" => "sm",
                                      "flex" => 3
                                    ],
                                    [
                                      "type" => "text",
                                      "text" => $data['tb_silp_line'][$key]['emp_name'],
                                      "wrap" => true,
                                      "color" => "#666666",
                                      "size" => "sm",
                                      "flex" => 5
                                    ]
                                  ]
                                ],
                                [
                                  "type" => "box",
                                  "layout" => "baseline",
                                  "spacing" => "sm",
                                  "contents" => [
                                    [
                                      "type" => "text",
                                      "text" => "แผนก : ",
                                      "color" => "#aaaaaa",
                                      "size" => "sm",
                                      "flex" => 3
                                    ],
                                    [
                                      "type" => "text",
                                      "text" => $data['tb_silp_line'][$key]['posbranch_name'],
                                      "wrap" => true,
                                      "color" => "#666666",
                                      "size" => "sm",
                                      "flex" => 5
                                    ]
                                  ]
                                ],
                               [
                                  "type" => "box",
                                  "layout" => "baseline",
                                  "spacing" => "sm",
                                  "contents" => [
                                    [
                                      "type" => "text",
                                      "text" => "สาขา :",
                                      "color" => "#aaaaaa",
                                      "size" => "sm",
                                      "flex" => 3
                                    ],
                                    [
                                      "type" => "text",
                                      "text" => $data['tb_silp_line'][$key]['branch_name'],
                                      "wrap" => true,
                                      "color" => "#666666",
                                      "size" => "sm",
                                      "flex" => 5
                                    ]
                                  ]
                                ],
                                [
                                  "type" => "box",
                                  "layout" => "baseline",
                                  "spacing" => "sm",
                                  "contents" => [
                                    [ 
                                      "type" => "text",
                                      "text" => "วันที่จ่าย :",
                                      "color" => "#aaaaaa",
                                      "size" => "sm",
                                      "flex" => 3
                                    ],
                                    [
                                      "type" => "text",
                                      "text" => $data['tb_silp_line'][$key]['pay_date'],
                                      "wrap" => true,
                                      "color" => "#666666",
                                      "size" => "sm",
                                      "flex" => 5
                                    ]
                                  ]
                                ]
                              ]
                            ]
                          ]
                        ],
                        "footer" => [
                          "type" => "box",
                          "layout" => "vertical",
                          "spacing" => "sm",
                          "contents" => [
                            [
                              "type" => "button",
                              "style" => "primary",
                              "height" => "sm",
                              "action" => [
                                "type" => "uri",
                                "label" => "คลิก ดาว์นโหลด",
                                "uri" => $data['tb_silp_line'][$key]['link_silp']
                              ]
                            ],
                            [
                              "type" => "box",
                              "layout" => "vertical",
                              "contents" => [],
                              "margin" => "sm"
                            ]
                          ],
                          "flex" => 0
                        ]
                    
                ];

                $messages = [
                    "response_type" => "object",
                    "line_payload" => [
                        [
                            "type" => "flex",
                            "altText" => "สลิปเงินเดือนของคุณ",
                            "contents" => [
                                "type" => "carousel",
                                "contents" => 
                                    $carousel_pay
                                
                              ]
                        ]
                    ]

                ];
            }

            return $this->respond($messages);
            
        } else {
            $response = [

                'satatus' => "not_pass"
            ];
            return $this->respond($response);
        }
    }
}
