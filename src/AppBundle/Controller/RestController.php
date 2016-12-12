<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Group;
use AppBundle\Entity\Record;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRecord;
use AppBundle\Factory\SummaryFactory;
use AppBundle\Repository\GroupRepository;
use AppBundle\Repository\RecordRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Utils\KeyGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestController extends Controller
{
    const ASC_SORT = 'ASC';
    const DESC_SORT = 'DESC';

    private $valideteSort = [
        self::ASC_SORT,
        self::DESC_SORT
    ];
    /**
     * @Route("/group", name="add_group")
     * @Method({"POST"})
     */
    public function actionAddGroup(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            /** @var KeyGenerator $keyGenerator */
            $keyGenerator = $this->get('app.key_generator');
            $group = new Group();
            $group->setGroupKey($keyGenerator->generateUniqueKey());

            $content = json_decode($request->getContent());
            $group->setName($content->groupName);
            foreach ($content->users as $user) {
                $obj = new User($user->login);
                $obj->setGroup($group);
                $em->persist($obj);
            }

            $em->persist($group);
            $em->flush();
            $ret = [
                'groupKey' => $group->getGroupKey()
            ];
            return $this->getResponse($ret);
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @Route("/group/{groupKey}", name="get_group")
     * @Method({"GET"})
     *
     * @param string $groupKey
     * @return JsonResponse
     */
    public function actionGetGroup($groupKey)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            /** @var GroupRepository $groupRepository */
            $groupRepository = $em->getRepository("AppBundle:Group");
            $group = $groupRepository->findByGroupKey($groupKey);
            $groupUsers = [];
            foreach ($group->getUsers() as $user) {
                $groupUsers[] = [
                    'id' => $user->getId(),
                    'login' => $user->getLogin()
                ];
            }
            $ret = [
                'groupKey' => $groupKey,
                'groupName' => $group->getName(),
                'users' => $groupUsers,
                'creationDate' => $group->getCreated()->getTimestamp(),
                'updateDate' => $group->getUpdated()->getTimestamp()
            ];
            return $this->getResponse($ret);
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @Route("/group/{groupKey}/record", name="add_record")
     * @Method({"POST"})
     *
     * @param $groupKey
     * @param Request $request
     * @return JsonResponse
     */
    public function actionAddRecord($groupKey, Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            /** @var GroupRepository $groupRepository */
            $groupRepository = $em->getRepository("AppBundle:Group");
            /** @var UserRepository $userRepository */
            $userRepository = $em->getRepository("AppBundle:User");
            $group = $groupRepository->findByGroupKey($groupKey);

            $content = json_decode($request->getContent());
            $record = Record::createRecordFromContent($content, $group);
            foreach ($content->users as $user) {
                $userObj = $userRepository->findOneByIdAndGroup($user->id, $group->getId());
                $userRecord = UserRecord::createFromContent($user);
                $userRecord->setUser($userObj);
                $userRecord->setRecord($record);
                $record->addUserRecords($userRecord);
                $em->persist($userRecord);
            }

            $em->persist($record);
            $em->flush();

            $recordUsers = [];
            foreach ($record->getUserRecords() as $userRecord) {
                $recordUsers[] = [
                    'id' => $userRecord->getUser()->getId(),
                    'value' => $userRecord->getValue(),
                    'currency' => $userRecord->getCurrency(),
                    'participation' => $userRecord->getParticipation()
                ];
            }

            $ret = [
                'id' => $record->getId(),
                'name' => $record->getName(),
                'coordinates' => [
                    'lat' => $record->getLat(),
                    'lon' => $record->getLon()
                ],
                'recordedDate' => [
                    'timestamp'
                ],
                'users' => $recordUsers
            ];
            return new JsonResponse($ret);
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @Route("/group/{groupKey}/record/{recordId}", name="delete_record")
     * @Method("DELETE")
     *
     * @param $groupKey
     * @param $recordId
     * @return JsonResponse
     */
    public function actionDeleteRecord($groupKey, $recordId)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            /** @var RecordRepository $recordRepository */
            $recordRepository = $em->getRepository("AppBundle:Record");
            /** @var GroupRepository $groupRepository */
            $groupRepository = $em->getRepository("AppBundle:Group");
            $group = $groupRepository->findByGroupKey($groupKey);
            $record = $recordRepository->findOneByIdAndGroup($recordId, $group->getId());
            $em->remove($record);
            $em->flush();

            $ret = [
                'id' => $recordId
            ];
            return $this->getResponse($ret);
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @Route("/group/{groupKey}/record", name="edit_record")
     * @Method({"PUT"})
     *
     * @param string $groupKey
     * @param  Request $request
     * @return JsonResponse
     */
    public function actionEditRecord($groupKey, Request $request)
    {
        try {
            $content = json_decode($request->getContent());


            $em = $this->getDoctrine()->getManager();
            /** @var GroupRepository $groupRepository */
            $groupRepository = $em->getRepository("AppBundle:Group");
            /** @var UserRepository $userRepository */
            $userRepository = $em->getRepository("AppBundle:User");
            /** @var RecordRepository $recordRepository */
            $recordRepository = $em->getRepository("AppBundle:Record");

            $group = $groupRepository->findByGroupKey($groupKey);

            $record = $recordRepository->findOneByIdAndGroup($content->id, $group->getId());
            if($record->getUpdated()->getTimestamp() > $content->recordedDate->timestamp){
                throw new \Exception("Already updated!");
            }
            $record->setName($content->name);
            $record->setContentImage($content->contentImage);
            $record->setContentType($content->contentType);
            $record->setLat($content->coordinates->lat);
            $record->setLon($content->coordinates->lon);
            foreach ($content->users as $user) {
                $userObj = $userRepository->findOneByIdAndGroup($user->id, $group->getId());
                $userRecord = UserRecord::createFromContent($user);
                $userRecord->setUser($userObj);
                $userRecord->setRecord($record);
                $record->addUserRecords($userRecord);
                $em->persist($userRecord);
            }
            $em->flush();
            return $this->getResponse($record->__toArray());
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @Route("/group/{groupKey}/record", name="get_records")
     * @Method({"GET"})
     *
     * @param $groupKey
     * @return JsonResponse
     */
    public function actionGetRecords($groupKey, Request $request)
    {
        try {
            $sort = strtoupper($request->get('sort', 'ASC'));
            if(!in_array($sort, $this->valideteSort)){
                throw new \Exception("Wrong sort attribute '".$sort."'!");
            }

            $em = $this->getDoctrine()->getManager();
            /** @var GroupRepository $groupRepository */
            $groupRepository = $em->getRepository("AppBundle:Group");
            /** @var RecordRepository $recordRepository */
            $recordRepository = $em->getRepository("AppBundle:Record");
            $group = $groupRepository->findByGroupKey($groupKey);
            $records = $recordRepository->findByGroupIdAsArray($group->getId(), $sort);
            $ret = [
                'groupName' => $group->getName(),
                'records' => $records
            ];
            return $this->getResponse($ret);
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @Route("/group/{groupKey}/summary", name="get_summary")
     * @Method({"GET"})
     *
     * @param $groupKey
     * @return JsonResponse
     */
    public function actionGetSummary($groupKey)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            /** @var GroupRepository $groupRepository */
            $groupRepository = $em->getRepository("AppBundle:Group");
            $group = $groupRepository->findByGroupKey($groupKey);
            /** @var SummaryFactory $summaryFactory */
            $summaryFactory = $this->get('app.factory.summary');
            $summary = $summaryFactory->createSummary($group);
            $ret = [
                'groupId' => $group->getId(),
                'summaryCost' => $summary->getCost(),
                'users' => $summary->getUsersSummary()
            ];
            return $this->getResponse($ret);
        } catch (\Exception $ex) {
            return $this->getExceptionResponse($ex);
        }
    }

    /**
     * @param array $ret
     * @return JsonResponse
     */
    private function getResponse(array $ret)
    {
        return new JsonResponse($ret);
    }

    /**
     * @param \Exception $exception
     * @return JsonResponse
     */
    private function getExceptionResponse(\Exception $exception)
    {
        $ret = [
            'type' => get_class($exception),
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];
        return new JsonResponse($ret);
    }

}