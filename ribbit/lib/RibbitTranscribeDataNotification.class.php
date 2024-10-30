<?php
/*
Copyright (c) 2010, Ribbit / BT Group PLC
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice,
this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this
list of conditions and the following disclaimer in the documentation and/or other
materials provided with the distribution.

Neither the name of BT Group PLC, Ribbit Corporation, nor the names of its contributors
may be used to endorse or promote products derived from this software without specific prior
written permission

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT
SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT
OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
/**
 * This Callback Notification is received when transcription of a voicemail is completed
 */
class RibbitTranscribeDataNotification extends RibbitCallbackNotification
{
    /**
     * Called internally.
     * Deserializes the JSON sent from the Ribbit REST server
     */
    public function RibbitTranscribeDataNotification($obj)
    {
        parent::RibbitCallbackNotification($obj);
    }
    /**
     * The text of a transcription
     *
     * @return string The text of a transcription
     */
    public function getTranscription()
    {
        $result = $this->getParameter("transcription");
        $result = urldecode(urldecode(urldecode($result)));
        return $result;
    }
    /**
     * A unique identifier for a call
     *
     * @return int A unique identifier for a call
     */
    public function getCallId()
    {
        $result = $this->getParameter("callId");
        return $result;
    }
    /**
     * The user id associated with the affected resource
     *
     * @return string The user id associated with the affected resource
     */
    public function getUserId()
    {
        $result = $this->getParameter("guid");
        return $result;
    }
}
?>