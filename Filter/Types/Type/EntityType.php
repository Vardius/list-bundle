<?php
/**
 * This file is part of the tipper package.
 *
 * (c) Rafał Lorenz <vardius@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vardius\Bundle\ListBundle\Filter\Types\Type;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vardius\Bundle\ListBundle\Event\FilterEvent;
use Vardius\Bundle\ListBundle\Filter\Types\FilterType;

/**
 * EntityType
 *
 * @author Rafał Lorenz <vardius@gmail.com>
 */
class EntityType extends FilterType
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('property', 'id');
        $resolver->setDefault('joinType', 'innerJoin');
        $resolver->addAllowedTypes('property', 'string');
        $resolver->addAllowedTypes('joinType', 'string');
        $resolver->addAllowedValues(['joinType' => ['leftJoin', 'innerJoin', 'join']]);
    }

    /**
     * @inheritDoc
     */
    public function apply(FilterEvent $event, array $options)
    {
        $queryBuilder = $event->getQueryBuilder();
        $value = $event->getValue();

        if ($value) {
            $field = empty($options['field']) ? $event->getField() : $options['field'];

            $queryBuilder
                ->{$options['joinType']}($event->getAlias() . '.' . $field, $field)
                ->andWhere($field . '.' . $options['property'] . ' = :vardius_entity_' . $field)
                ->setParameter('vardius_entity_' . $field, $value);
        }

        return $queryBuilder;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'entity';
    }

}