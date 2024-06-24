<?php

declare(strict_types=1);

namespace Apb\MediaBundle\Form;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

readonly class MediaCreateType
{
    public function __construct(
        private ParameterBagInterface $bag,
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'constraints' => [
                    new File(array_filter([
                        'maxSize' => $this->bag->get('media_bundle')['max_size'] ?? null,
                        'mimeTypes' => $this->bag->get('media_bundle')[' allowed_mime_types'] ?? null,
                    ])),
                    new NotNull(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ]);
    }
}