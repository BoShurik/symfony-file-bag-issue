<?php
/**
 * User: boshurik
 * Date: 24.12.19
 * Time: 15:42
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('files', CollectionType::class, [
                'entry_type' => FileType::class,
                'entry_options' => [
                    'required' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'class' => 'js-collection',
                ],
            ])
        ;

        $builder->get('files')->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = (array)$event->getForm()->getData();
            $exist = [];
            foreach ((array)$event->getData() as $index => $item) {
                // Expect 0 => null for not uploaded file
                if ($item !== null) {
                    $data[$index] = $item; // Replace newly uploaded file
                }

                $exist[$index] = true;
            }

            $keys = array_keys($data);
            foreach ($keys as $key) {
                if (!isset($exist[$key])) {
                    unset($data[$key]); // Remove deleted element
                }
            }

            $event->setData($data);
        });
    }
}
