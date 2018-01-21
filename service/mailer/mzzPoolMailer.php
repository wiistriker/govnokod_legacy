<?php
fileLoader::load('service/mailer/abstractMailer');
class mzzPoolMailer extends abstractMailer
{
    protected $db;
    protected $insert;
    protected $table = 'mailer_mail';

    public function __construct(Array $params = array())
    {
        $this->db = DB::factory();
        $criteria = new criteria($this->table);
        $this->insert = new simpleInsert($criteria);
    }

    public function send()
    {
        $data = array(
            'to' => $this->getTo(),
            'toName' => $this->getToName(),
            'from' => $this->getFrom(),
            'fromName' => $this->getFromName(),
            'subject' => $this->getSubject(),
            'body' => $this->getBody(),
            'created' => time()
        );

        $this->db->query($this->insert->toString($data));

        return true;
    }
}
?>