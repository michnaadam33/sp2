<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RestController
{
    /**
     * @Route("/group", name="add_group")
     * @Method({"POST"})
     */
    public function actionAddGroup(){
        return new JsonResponse(['todo']);
    }

    /**
     * @Route("/group/{groupKey}", name="get_group")
     * @Method({"GET"})
     *
     * @param string $groupKey
     * @return JsonResponse
     */
    public function actionGetGroup($groupKey){
        $ret = [
            'groupKey' => $groupKey
        ];
        return new JsonResponse($ret);
    }

    /**
     * @Route("/group/{groupKey}/record", name="add_record")
     * @Method({"POST"})
     *
     * @param $groupKey
     * @return JsonResponse
     */
    public function actionAddRecord($groupKey){
        $ret = [

        ];
        return new JsonResponse($ret);
    }

    /**
     * @Route("/group/{groupKey}/record/{recordId}", name="delete_record)
     * @Method({"DELETE"})
     *
     * @param $groupKey
     * @param $recordId
     * @return JsonResponse
     */
    public function actionDeleteRecord($groupKey, $recordId){
        $ret = [

        ];
        return new JsonResponse($ret);
    }

    /**
     * @Route("/group/{groupKey}/record", name="edit_record)
     * @Method({"PUT"})
     *
     * @param $groupKey
     * @return JsonResponse
     */
    public function actionEditRecord($groupKey){
        $ret = [

        ];
        return new JsonResponse($ret);
    }

    /**
     * @Route("/group/{groupKey}/record", name="get_records)
     * @Method({"GET"})
     *
     * @param $groupKey
     * @return JsonResponse
     */
    public function actionGEtRecords($groupKey){
        $ret = [

        ];
        return new JsonResponse($ret);
    }

    /**
     * @Route("/group/{groupKey}/summary", name="edit_summary)
     * @Method({"GET"})
     *
     * @param $groupKey
     * @return JsonResponse
     */
    public function actionGetSummary($groupKey){
        $ret = [

        ];
        return new JsonResponse($ret);
    }

}