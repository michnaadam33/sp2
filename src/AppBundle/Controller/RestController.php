<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use AppBundle\Utils\KeyGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RestController extends Controller
{
    /**
     * @Route("/group", name="add_group")
     * @Method({"POST"})
     */
    public function actionAddGroup(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        /** @var KeyGenerator $keyGenerator */
        $keyGenerator = $this->get('app.key_generator');
        $group = new Group();
        $group->setGroupKey($keyGenerator->generateUniqueKey());

        $content = json_decode($request->getContent());
        $group->setName($content->groupName);
        foreach ($content->users as $user){
            $obj = new User($user->login);
            $obj->setGroup($group);
            $em->persist($obj);
        }
        
        $em->persist($group);
        $em->flush();
        $ret = [
            'groupKey' => $group->getGroupKey()
        ];
        return new JsonResponse($ret);
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
     * @Route("/group/{groupKey}/record/{recordId}", name="delete_record")
     * @Method("DELETE")
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
     * @Route("/group/{groupKey}/record", name="edit_record")
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
     * @Route("/group/{groupKey}/record", name="get_records")
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
     * @Route("/group/{groupKey}/summary", name="edit_summary")
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