<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180109182221 extends AbstractMigration
{
    public function up(Schema $schema)
    {

        $idQuery = $this
            ->connection
            ->createQueryBuilder()
            ->select('id', 'canonical')
            ->from('project')
            ->where('canonical = :default_value')
            ->setParameter('default_value', 'common')
        ;

        $result = ($idQuery->execute())->fetch(\PDO::FETCH_OBJ);
        if( ! $result ) {
            $this->addSql(
                'insert into project (canonical, name, description) values (:canonical, :name, :description)',
                ['canonical' => 'common', 'name' => 'Common translations', 'description' => 'Common translations']
            );
        }

        $this->addSql('update trans_unit set project_id = (select id from project where canonical = :canonical) where project_id is null',
            ['canonical' => 'common'])
            ;

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
