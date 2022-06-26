<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\FindCategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class FindCategoryAction extends AbstractController
{
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        CategoryRepository $categoryRepository
    ): Category
    {
        /** @var FindCategoryDto $findCategoryDto */
        $findCategoryDto = $serializer->deserialize($request->getContent(), FindCategoryDto::class, 'json');

        $foundCategory = $categoryRepository->findOneByName($findCategoryDto->getName());

        if ($foundCategory === null) {
            throw new NotFoundHttpException('Bunday categoriya topilmadi');
        }

        return $foundCategory;
    }
}