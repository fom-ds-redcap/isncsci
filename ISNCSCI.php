<?php

namespace FOMDS\ISNCSCI;

use REDCap;

class ISNCSCI extends \ExternalModules\AbstractExternalModule 
{
    /**
     * Check if ISNCSCI form is installed as a form in the project, otherwise prompt users to install it.
     * @param int $project_id
     */
    public function redcap_every_page_top($project_id) 
    {
        $form_installed = false;
        
        $unique_event_names = REDCap::getEventNames(true, true);
        
        foreach($unique_event_names as $unique_event_name)
        {
            $event_id = REDCap::getEventIdFromUniqueEvent($unique_event_name);
            
            $forms_for_event = $this->getFormsForEventId($event_id);
            
            if (in_array("isncsci_exam", $forms_for_event)) {
                $form_installed = true;
                break;
            }
        }
        
        if (!$form_installed) {
             ?>
             <script type="text/javascript">
                $(document).ready(function(){
                    var html = "<div class='yellow'><b>WARNING:</b> You have installed the ISNCSCI external module, but not the associated form, or have not assigned it to an event. Without it, you cannot save module data to your redcap project. Please install the form from our GitHub repository, and <b>do not rename it</b>.</div>";
                    $("#subheader").after($(html));
                });
             </script>
             <?php
        }
    }
}