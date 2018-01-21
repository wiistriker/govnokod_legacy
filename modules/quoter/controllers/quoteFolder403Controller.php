<?php
class quoteFolder403Controller extends simpleController
{
    protected function getView()
    {
        $this->response->setStatus(403);

        $this->smarty->assign('request', $this->request);
        return $this->smarty->fetch('quoter/quoteFolder403.tpl');
    }
}
?>