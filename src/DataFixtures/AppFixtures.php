<?php

namespace App\DataFixtures;

use App\Entity\Events;
use App\Entity\Location;
use App\Entity\Membership;
use App\Entity\Payment;
use App\Entity\Season;
use App\Entity\Team;
use App\Entity\TeamMember;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $season = $this->createSeason($manager);
        $users = $this->createUsers($manager);
        $teams = $this->createTeams($manager, $season);
        $this->createTeamMembers($manager, $teams, $users);
        $this->createMemberships($manager, $season, $users);
        $this->createEvents($manager, $teams, $this->createLocations($manager), $users);

        $manager->flush();
    }

    private function createSeason(ObjectManager $manager): Season
    {
        // La saison va du 1er septembre au 31 août
        $today = new \DateTimeImmutable('today');
        $year = (int) $today->format('Y');
        if ((int) $today->format('n') < 9) {
            --$year;
        }

        $season = (new Season())
            ->setName(sprintf('%d-%d', $year, $year + 1))
            ->setStartDate(new \DateTimeImmutable("$year-09-01"))
            ->setEndDate(new \DateTimeImmutable(($year + 1).'-08-31'))
            ->setIsActive(true);
        $manager->persist($season);

        return $season;
    }

    /**
     * @return array<string, Users>
     */
    private function createUsers(ObjectManager $manager): array
    {
        $data = [
            // clé => [prénom, rôles]
            'admin' => ['Alice', ['ROLE_ADMIN', 'ROLE_ADHERENT']],
            'coach1' => ['Karim', ['ROLE_COACH', 'ROLE_ADHERENT']],
            'coach2' => ['Julie', ['ROLE_COACH']],
            'joueur1' => ['Lucas', ['ROLE_ADHERENT']],
            'joueur2' => ['Emma', ['ROLE_ADHERENT']],
            'joueur3' => ['Hugo', ['ROLE_ADHERENT']],
            'joueur4' => ['Sarah', ['ROLE_ADHERENT']],
            'joueur5' => ['Nathan', ['ROLE_ADHERENT']],
        ];

        // Mot de passe de test, uniquement pour le développement
        $hash = password_hash('password', PASSWORD_DEFAULT);
        $now = new \DateTimeImmutable();
        $users = [];

        foreach ($data as $key => [$firstName, $roles]) {
            $user = (new Users())
                ->setEmail("$key@example.com")
                ->setPassword($hash)
                ->setFirstName($firstName)
                ->setLastName('Test')
                ->setPhone('0000000000')
                ->setRoles($roles)
                ->setIsActive(true)
                ->setCreatedAt($now)
                ->setUpdatedAt($now);
            $manager->persist($user);
            $users[$key] = $user;
        }

        return $users;
    }

    /**
     * @return array<string, Team>
     */
    private function createTeams(ObjectManager $manager, Season $season): array
    {
        $teams = [];

        foreach (['seniors' => ['Équipe Seniors', 'Seniors'], 'loisirs' => ['Équipe Loisirs', 'Loisirs']] as $key => [$name, $category]) {
            $team = (new Team())
                ->setName($name)
                ->setCategory($category)
                ->setSeasonId($season);
            $manager->persist($team);
            $teams[$key] = $team;
        }

        return $teams;
    }

    /**
     * @param array<string, Team>  $teams
     * @param array<string, Users> $users
     */
    private function createTeamMembers(ObjectManager $manager, array $teams, array $users): void
    {
        // joueur3 fait partie des deux équipes
        $composition = [
            'seniors' => ['coach1', 'joueur1', 'joueur2', 'joueur3'],
            'loisirs' => ['coach2', 'joueur3', 'joueur4', 'joueur5'],
        ];

        foreach ($composition as $teamKey => $userKeys) {
            foreach ($userKeys as $userKey) {
                $manager->persist((new TeamMember())
                    ->setUserId($users[$userKey])
                    ->setTeamId($teams[$teamKey])
                    );
            }
        }
    }

    /**
     * @param array<string, Users> $users
     */
    private function createMemberships(ObjectManager $manager, Season $season, array $users): void
    {
        $data = [
            // utilisateur => [statut, certificat médical, motif de rejet]
            'admin' => ['Terminé', true, null],
            'coach1' => ['Terminé', true, null],
            'joueur1' => ['Terminé', true, null],
            'joueur2' => ['Terminé', true, null],
            'joueur3' => ['Terminé', true, null],
            'joueur4' => ['En cours', null, null],
            'joueur5' => ['En cours', false, null],
            // coach2 n'est pas adhérente : pas d'adhésion
        ];

        $number = 0;

        foreach ($data as $userKey => [$status, $medicalCheck, $rejection]) {
            $membership = (new Membership())
                ->setUserId($users[$userKey])
                ->setSeasonId($season)
                ->setStatus($status)
                ->setMedicalCheck($medicalCheck)
                ->setRejection($rejection);
            $manager->persist($membership);

            $manager->persist((new Payment())
                ->setMembershipId($membership)
                ->setAmount('120.00')
                ->setDate(new \DateTimeImmutable('today'))
                ->setMethod(0 === $number % 2 ? 'Carte bancaire' : 'Chèque')
                ->setStatus($status)
                ->setReference(sprintf('TEST-%03d', ++$number)));
        }
    }

    /**
     * @return array<string, Location>
     */
    private function createLocations(ObjectManager $manager): array
    {
        $data = [
            'gymnase' => ['Gymnase Test', '1 rue de l’Exemple'],
            'salle' => ['Salle Démo', '2 avenue Fictive'],
        ];
        $locations = [];

        foreach ($data as $key => [$name, $address]) {
            $location = (new Location())
                ->setName($name)
                ->setAdress($address)
                ->setCity('Villetest');
            $manager->persist($location);
            $locations[$key] = $location;
        }

        return $locations;
    }

    /**
     * @param array<string, Team>     $teams
     * @param array<string, Location> $locations
     * @param array<string, Users>    $users
     */
    private function createEvents(ObjectManager $manager, array $teams, array $locations, array $users): void
    {
        // [type, équipe, lieu, début, durée en heures, statut, créateur, description]
        $data = [
            ['Entraînement', 'seniors', 'gymnase', '-7 days 19:00', 2, 'Terminé', 'coach1', 'Entraînement hebdomadaire'],
            ['Match', 'seniors', 'salle', '+3 days 20:00', 2, 'En cours', 'coach1', 'Match amical'],
            ['Entraînement', 'loisirs', 'gymnase', '+5 days 18:30', 2, 'En cours', 'coach2', null],
            ['Match', 'loisirs', 'salle', '+10 days 15:00', 2, 'Abandonné', 'coach2', 'Match abandonné'],
            // Un événement général ne concerne aucune équipe en particulier
            ['Général', null, 'gymnase', '+20 days 18:00', 3, 'En cours', 'admin', 'Soirée du club'],
        ];

        foreach ($data as [$type, $teamKey, $locationKey, $start, $hours, $status, $creatorKey, $description]) {
            $startDate = new \DateTimeImmutable($start);

            $manager->persist((new Events())
                ->setType($type)
                ->setTeamId(null === $teamKey ? null : $teams[$teamKey])
                ->setLocationId($locations[$locationKey])
                ->setStartDate($startDate)
                ->setEndDate($startDate->modify("+$hours hours"))
                ->setStatus($status)
                ->setCreatedBy($users[$creatorKey])
                ->setDescription($description));
        }
    }
}