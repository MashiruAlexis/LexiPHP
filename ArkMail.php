<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2016 Ramon Alexis Celis
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

 Class ArkMail extends CI_Model {

 	/**
     * imap connection
     */
    protected $imap = false;
    
    /**
     * mailbox url string
     */
    protected $mailbox = "";
    
    /**
     * currentfolder
     */
    protected $folder = "Inbox";
    
    /**
     *  Hosts
     */
    public $host = array("hostgator" => "{gator3029.hostgator.com:993/imap/ssl}INBOX",
                            "gmail" => "{imap.gmail.com:993/imap/ssl}INBOX");

    /**
     *  Email
     */
    public $email = "******";

    /**
     *  Password
     */
    public $password = "******";

    /**
     *  Type
     */
    public $connType = null;
    

    /**
     *  Connect
     */
    public function connect() {
        $mailbox = $this->host[$this->type];
        $username = $this->email;
        $password = base64_decode($this->password);
        $this->mailbox = $mailbox;
        $this->imap = imap_open($this->mailbox, $username, $password);
        if($this->isConnected()===false) {
            die($this->getError());
        }

        // $folders = $this->getFolders(); // returns array of strings
        // foreach($folders as $folder) {
        //     echo $folder . "<br/>";
        // }

        $this->selectFolder("");
        $emails = $this->getMessages(30);


        foreach($emails as $mails) {
            $this->db->where('mailid', $mails["uid"]);
                $x = $this->db->get('tbl_mail')->num_rows();
                if ($x == 0) {
                    $this->db->insert("tbl_mail", array("mailid" => $mails["uid"],
                                                        "mail_from" => $mails["from"],
                                                        "mail_subject" => $mails["subject"],
                                                        "date" => date("Y-m-d h:i:s", strtotime($mails["date"])),
                                                        "mail_body" => $mails["body"] ));

                    if(isset($mails["attachments"])) {
                        // echo "<pre>";
                        // print_r($mails["attachments"]); exit();
                        $this->dlAttachment($mails["uid"]);
                    }
                }
        }

    }

    /**
     *  Flat the arrays
     */
    public function flatArray($arg) {
        return is_array($arg) ? array_reduce($arg, function ($c, $a) { return array_merge($c, $this->flatArray($a)); },[]) : [$arg];
    }

    /**
     *  Date format
     */
    public function dateFormat($varDate) {
        $varDate = strtotime($varDate);
        return date("D, M j, Y h:i:s a", $varDate);
    }
    
    
    /**
     * close connection
     */
    function __destruct() {
        if($this->imap!==false)
            imap_close($this->imap);
    }
   
   
    /**
     * returns true after successfull connection
     */
    public function isConnected() {
        return $this->imap !== false;
    }
    
    
    /**
     * returns last imap error
     */
    public function getError() {
        return imap_last_error();
    }
    
    
    /**
     * select given folder
     */
    public function selectFolder($folder) {
        $result = imap_reopen($this->imap, $this->mailbox . $folder);
        if($result === true)
            $this->folder = $folder;
        return $result;
    }
    
    
    /**
     * returns all available folders
     */
    public function getFolders() {
        $folders = imap_list($this->imap, $this->mailbox, "*");
        return str_replace($this->mailbox, "", $folders);
    }
    
    
    /**
     * returns the number of messages in the current folder
     */
    public function countMessages() {
        return imap_num_msg($this->imap);
    }
    
    
    /**
     * returns the number of unread messages in the current folder
     */
    public function countUnreadMessages() {
        $result = imap_search($this->imap, 'UNSEEN');
        if($result===false)
            return 0;
        return count($result);
    }
    /**
     * returns unseen emails in the current folder
     */
    public function getUnreadMessages($withbody=true){
        $emails = [];
        $result = imap_search($this->imap, 'UNSEEN');
        if($result){
            foreach($result as $k=>$i){
                $emails[]= $this->formatMessage($i, $withbody);
            }
        }
        return $emails;
    }
    
    
    /**
     * returns all emails in the current folder
     */
    public function getMessages($limit = false, $withbody = true) {
        $count = $this->countMessages();
        $emails = array();
        for($i=1;$i<=$count;$i++) {
            $emails[]= $this->formatMessage($i, $withbody);
            if($limit) {
                if($i >= $limit) {
                    break;
                }
            }
        }
        return $emails;
    }
    
    /**
     * returns email by given id
     */
    public function getMessage($id, $withbody = true) {
        return $this->formatMessage($id, $withbody);
    }
    
    /**
     * Format Message
     */
    protected function formatMessage($id, $withbody=true){
        $header = imap_headerinfo($this->imap, $id);
        // fetch unique uid
        $uid = imap_uid($this->imap, $id);
    
        // get email data
        $subject = '';
        if ( isset($header->subject) && strlen($header->subject) > 0 ) {
            foreach(imap_mime_header_decode($header->subject) as $obj){
                $subject .= $obj->text;
            }
        }
        $subject = $this->convertToUtf8($subject);
        $email = array(
            'to'       => isset($header->to) ? $this->arrayToAddress($header->to) : '',
            'from'     => $this->toAddress($header->from[0]),
            'date'     => $header->date,
            'subject'  => $subject,
            'uid'       => $uid,
            'unread'   => strlen(trim($header->Unseen))>0,
            'answered' => strlen(trim($header->Answered))>0,
            'deleted' => strlen(trim($header->Deleted))>0
        );
        if(isset($header->cc))
            $email['cc'] = $this->arrayToAddress($header->cc);
        // get email body
        if($withbody===true) {
            $body = $this->getBody($uid);
            $email['body'] = $body['body'];
            $email['html'] = $body['html'];
        }
        // get attachments
        $mailStruct = imap_fetchstructure($this->imap, $id);
        $attachments = $this->attachments2name($this->getAttachments($this->imap, $id, $mailStruct, ""));
        if(count($attachments)>0) {
            foreach ($attachments as $val) {
                foreach ($val as $k=>$t) {
                    if ($k == 'name') {
                        $decodedName = imap_mime_header_decode($t);
                        $t = $this->convertToUtf8($decodedName[0]->text);
                    }
                $arr[$k] = $t;
                }
            $email['attachments'][] = $arr;
            }
        }
        return $email;
    }
    
    /**
     * delete given message
     */
    public function deleteMessage($id) {
        return $this->deleteMessages(array($id));
    }
    
    
    /**
     * delete messages
     */
    public function deleteMessages($ids) {
        if( imap_mail_move($this->imap, implode(",", $ids), $this->getTrash(), CP_UID) == false)
            return false;
        return imap_expunge($this->imap);
    }
    
    
    /**
     * move given message in new folder
     */
    public function moveMessage($id, $target) {
        return $this->moveMessages(array($id), $target);
    }
    
    
    /**
     * move given message in new folder
     */
    public function moveMessages($ids, $target) {
        if(imap_mail_move($this->imap, implode(",", $ids), $target, CP_UID)===false)
            return false;
        return imap_expunge($this->imap);
    }
    
    
    /**
     * mark message as read
     */
    public function setUnseenMessage($id, $seen = true) {
        $header = $this->getMessageHeader($id);
        if($header==false)
            return false;
            
        $flags = "";
        $flags .= (strlen(trim($header->Answered))>0 ? "\\Answered " : '');
        $flags .= (strlen(trim($header->Flagged))>0 ? "\\Flagged " : '');
        $flags .= (strlen(trim($header->Deleted))>0 ? "\\Deleted " : '');
        $flags .= (strlen(trim($header->Draft))>0 ? "\\Draft " : '');
        
        $flags .= (($seen == true) ? '\\Seen ' : ' ');
        //echo "\n<br />".$id.": ".$flags;
        imap_clearflag_full($this->imap, $id, '\\Seen', ST_UID);
        return imap_setflag_full($this->imap, $id, trim($flags), ST_UID);
    }
    
    
    /**
     * return content of messages attachment
     */
    public function getAttachment($id, $index = 0) {
        // find message
        $attachments = false;
        $messageIndex = imap_msgno($this->imap, $id);
        $header = imap_headerinfo($this->imap, $messageIndex);
        $mailStruct = imap_fetchstructure($this->imap, $messageIndex);
        $attachments = $this->getAttachments($this->imap, $messageIndex, $mailStruct, "");
        
        if($attachments==false)
            return false;
        
        // find attachment
        if($index > count($attachments))
            return false;
        $attachment = $attachments[$index];
        
        // get attachment body
        $partStruct = imap_bodystruct($this->imap, imap_msgno($this->imap, $id), $attachment['partNum']);
        $filename = $partStruct->dparameters[0]->value;
        $message = imap_fetchbody($this->imap, $id, $attachment['partNum'], FT_UID);
     
        switch ($attachment['enc']) {
            case 0:
            case 1:
                $message = imap_8bit($message);
                break;
            case 2:
                $message = imap_binary($message);
                break;
            case 3:
                $message = imap_base64($message);
                break;
            case 4:
                $message = quoted_printable_decode($message);
                break;
        }
     
        return array(
                "name" => $attachment['name'], 
                "size" => $attachment['size'],
                "content" => $message);
    }
    
    
    /**
     * add new folder
     */
    public function addFolder($name, $subscribe = false) {
        $success = imap_createmailbox($this->imap, $this->mailbox . $name);
        if ($success && $subscribe) {
            $success = imap_subscribe($this->imap, $this->mailbox . $name);
        }
        return $success;
    }
    
    
    /**
     * remove folder
     */
    public function removeFolder($name) {
        return imap_deletemailbox($this->imap, $this->mailbox . $name);
    }
    
    
    /**
     * rename folder
     */
    public function renameFolder($name, $newname) {
        return imap_renamemailbox($this->imap, $this->mailbox . $name, $this->mailbox . $newname);
    }
    
    
    /**
     * clean folder content of selected folder
     */
    public function purge() {
        // delete trash and spam
        if($this->folder==$this->getTrash() || strtolower($this->folder)=="spam") {
            if(imap_delete($this->imap,'1:*')===false) {
                return false;
            }
            return imap_expunge($this->imap);
        
        // move others to trash
        } else {
            if( imap_mail_move($this->imap,'1:*', $this->getTrash()) == false)
                return false;
            return imap_expunge($this->imap);
        }
    }
    
    
    /**
     * returns all email addresses
     */
    public function getAllEmailAddresses() {
        $saveCurrentFolder = $this->folder;
        $emails = array();
        foreach($this->getFolders() as $folder) {
            $this->selectFolder($folder);
            foreach($this->getMessages(false) as $message) {
                $emails[] = $message['from'];
                $emails = array_merge($emails, $message['to']);
                if(isset($message['cc']))
                    $emails = array_merge($emails, $message['cc']);
            }
        }
        $this->selectFolder($saveCurrentFolder);
        return array_unique($emails);
    }
    
    
    /**
     * save email in sent
     */
    public function saveMessageInSent($header, $body) {
        return imap_append($this->imap, $this->mailbox . $this->getSent(), $header . "\r\n" . $body . "\r\n", "\\Seen");
    }
    
    
    /**
     * explicitly close imap connection
     */
    public function close() {
        if($this->imap!==false)
            imap_close($this->imap);
    }
    
    
    
    // protected helpers
    
    
    /**
     * get trash folder name or create new trash folder
     */
    protected function getTrash() {
        foreach($this->getFolders() as $folder) {
            if(strtolower($folder)==="trash" || strtolower($folder)==="papierkorb")
                return $folder;
        }
        
        // no trash folder found? create one
        $this->addFolder('Trash');
        
        return 'Trash';
    }
    
    
    /**
     * get sent folder name or create new sent folder
     */
    protected function getSent() {
        foreach($this->getFolders() as $folder) {
            if(strtolower($folder)==="sent" || strtolower($folder)==="gesendet")
                return $folder;
        }
        
        // no sent folder found? create one
        $this->addFolder('Sent');
        
        return 'Sent';
    }
    
    
    /**
     * fetch message by id
     */
    protected function getMessageHeader($id) {
        $count = $this->countMessages();
        for($i=1;$i<=$count;$i++) {
            $uid = imap_uid($this->imap, $i);
            if($uid==$id) {
                $header = imap_headerinfo($this->imap, $i);
                return $header;
            }
        }
        return false;
    }
    
    
    /**
     * convert attachment in array(name => ..., size => ...).
     */
    protected function attachments2name($attachments) {
        $names = array();
        foreach($attachments as $attachment) {
            $names[] = array(
                'name' => $attachment['name'],
                'size' => $attachment['size']
            );
        }
        return $names;
    }
    
    
    /**
     * convert imap given address in string
     */
    protected function toAddress($headerinfos) {
        $email = "";
        $name = "";
        if(isset($headerinfos->mailbox) && isset($headerinfos->host)) {
            $email = $headerinfos->mailbox . "@" . $headerinfos->host;
        }
        if(!empty($headerinfos->personal)) {
            $name = imap_mime_header_decode($headerinfos->personal);
            $name = $name[0]->text;
        } else {
            $name = $email;
        }
        
        $name = $this->convertToUtf8($name);
        
        return $name . " <" . $email . ">";
    }
    
    /**
     * converts imap given array of addresses in strings
     */
    protected function arrayToAddress($addresses) {
        $addressesAsString = array();
        foreach($addresses as $address) {
            $addressesAsString[] = $this->toAddress($address);
        }
        return $addressesAsString;
    }
    
    /**
     * returns body of the email. First search for html version of the email, then the plain part.
     */
    protected function getBody($uid) {
        $body = $this->get_part($this->imap, $uid, "TEXT/HTML");
        $html = true;
        // if HTML body is empty, try getting text body
        if ($body == "") {
            $body = $this->get_part($this->imap, $uid, "TEXT/PLAIN");
            $html = false;
        }
        $body = $this->convertToUtf8($body);
        return array( 'body' => $body, 'html' => $html);
    }
    
    
    /**
     * convert to utf8 if necessary.
     */
    function convertToUtf8($str) { 
        if(mb_detect_encoding($str, "UTF-8, ISO-8859-1, GBK")!="UTF-8")
            $str = utf8_encode($str);
        $str = iconv('UTF-8', 'UTF-8//IGNORE', $str);
        return $str; 
    } 
    
    
    /**
     * returns a part with a given mimetype
     */
    protected function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
        if (!$structure) {
               $structure = imap_fetchstructure($imap, $uid, FT_UID);
        }
        if ($structure) {
            if ($mimetype == $this->get_mime_type($structure)) {
                if (!$partNumber) {
                    $partNumber = 1;
                }
                $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID | FT_PEEK);
                switch ($structure->encoding) {
                    case 3: return imap_base64($text);
                    case 4: return imap_qprint($text);
                    default: return $text;
               }
           }
     
            // multipart 
            if ($structure->type == 1) {
                foreach ($structure->parts as $index => $subStruct) {
                    $prefix = "";
                    if ($partNumber) {
                        $prefix = $partNumber . ".";
                    }
                    $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }
    
    
    /**
     * extract mimetype
     */
    protected function get_mime_type($structure) {
        $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
     
        if ($structure->subtype) {
           return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }
    
    
    /**
     * get attachments of given email
     */
    protected function getAttachments($imap, $mailNum, $part, $partNum) {
        $attachments = array();
     
        if (isset($part->parts)) {
            foreach ($part->parts as $key => $subpart) {
                if($partNum != "") {
                    $newPartNum = $partNum . "." . ($key + 1);
                } else {
                    $newPartNum = ($key+1);
                }
                $result = $this->getAttachments($imap, $mailNum, $subpart,
                    $newPartNum);
                if (count($result) != 0) {
                    array_push($attachments, $result);
                }
            }
        } else if (isset($part->disposition)) {
            if (strtolower($part->disposition) == "attachment") {
                $partStruct = imap_bodystruct($imap, $mailNum,
                    $partNum);
                $attachmentDetails = array(
                    "name"    => $part->dparameters[0]->value,
                    "partNum" => $partNum,
                    "enc"     => $partStruct->encoding,
                    "size"    => $part->bytes
                );
                return $attachmentDetails;
            }
        }
     
        return $attachments;
    }

    /**
    |
    |   Download Attachments
    |
    */ 
    public function dlAttachment($mailIds) {
        $email_number = $mailIds;
        $inbox = $this->imap;

        /* get mail structure */
        $structure = imap_fetchstructure($inbox, $email_number);

        $attachments = array();
        
        /* if any attachments found... */
        if(isset($structure->parts) && count($structure->parts)) 
        {
            for($i = 0; $i < count($structure->parts); $i++) 
            {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );
            
                if($structure->parts[$i]->ifdparameters) 
                {
                    foreach($structure->parts[$i]->dparameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'filename') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }
            
                if($structure->parts[$i]->ifparameters) 
                {
                    foreach($structure->parts[$i]->parameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'name') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }
            
                if($attachments[$i]['is_attachment']) 
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                    
                    /* 4 = QUOTED-PRINTABLE encoding */
                    if($structure->parts[$i]->encoding == 3) 
                    { 
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    /* 3 = BASE64 encoding */
                    elseif($structure->parts[$i]->encoding == 4) 
                    { 
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }
        
        /* iterate through each attachment and save it */
        foreach($attachments as $attachment)
        {
            if($attachment['is_attachment'] == 1)
            {
                $filename = $attachment['name'];
                if(empty($filename)) $filename = $attachment['filename'];
                
                if(empty($filename)) $filename = time() . ".dat";
                
                /* prefix the email number to the filename in case two emails
                 * have the attachment with the same file name.
                 */
                $fp = fopen("./" . $email_number . "-" . $filename, "w+");
                fwrite($fp, $attachment['attachment']);
                fclose($fp);
            }
        
        }
    }

    /**
     * Return general mailbox statistics
     */
    public function getMailboxStatistics() {
        return $this->isConnected() ? imap_mailboxmsginfo($this->imap) : false ;
    }

    public function __call($method, $params = null) {

        $type = substr($method, 0, 3);
        $property = lcfirst(substr($method, 3));


            if($type == "set") {
                $this->$property = $params[0];
                return $this;
            }elseif($type == "get") {
                return $this->$property;
            }else{
                echo "error";
            }
    }
 }
