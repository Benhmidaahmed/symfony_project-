<?php

// src/Repository/AppointmentRepository.php

namespace App\Repository;

use App\Entity\Appointment;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointment>
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    /**
     * Récupère les rendez-vous de la date actuelle.
     *
     * @param \DateTime $today
     * @return Appointment[]
     */
    public function findAppointmentsForToday(\DateTime $today): array
    {
        $startOfDay = (clone $today)->setTime(0, 0, 0); // Début de la journée
        $endOfDay = (clone $today)->setTime(23, 59, 59); // Fin de la journée

        return $this->createQueryBuilder('a')
            ->andWhere('a.date BETWEEN :start AND :end')
            ->setParameter('start', $startOfDay)
            ->setParameter('end', $endOfDay)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les rendez-vous de la date actuelle pour un utilisateur spécifique.
     *
     * @param User $user
     * @param \DateTime $today
     * @return Appointment[]
     */
    public function findAppointmentsForTodayByUser(User $user, \DateTime $today): array
    {
        $startOfDay = (clone $today)->setTime(0, 0, 0); // Début de la journée
        $endOfDay = (clone $today)->setTime(23, 59, 59); // Fin de la journée

        return $this->createQueryBuilder('a')
            ->andWhere('a.date BETWEEN :start AND :end')
            ->andWhere('a.user = :user')
            ->setParameter('start', $startOfDay)
            ->setParameter('end', $endOfDay)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}