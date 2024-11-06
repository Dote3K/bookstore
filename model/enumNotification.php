<?php

enum EnumNotification: string {
    case UNREAD = 'Chua doc';
    case READ = 'Da doc';

    public function getValue(): string {
        return $this->value;
    }
}
?>
