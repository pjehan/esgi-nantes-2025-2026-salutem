<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:delete-user',
    description: 'Delete a user',
    usages: ['1', 'user@salutem.fr']
)]
class DeleteUserCommand
{
    public function __invoke(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        SymfonyStyle $style,
        #[Argument(description: 'The id or email of the user to delete', suggestedValues: ['1', 'user@salutem.fr'])]
        string $idOrEmail,
        #[Option(description: 'Remove associated appointments')]
        bool $withAppointments = false
    ): int
    {
        $user = $userRepository->findOneByIdOrEmail($idOrEmail);

        if (!$user) {
            $style->error('User not found');
            return Command::FAILURE;
        }

        if ($withAppointments) {
            foreach ($user->getAppointments() as $appointment) {
                $entityManager->remove($appointment);
                $style->info('Removed appointment with id ' . $appointment->getId());
            }
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $style->success('User deleted successfully');

        return Command::SUCCESS;
    }
}
