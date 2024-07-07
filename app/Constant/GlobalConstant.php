<?php

namespace App\Constant;

class GlobalConstant
{
    public const STATUS_PENDING = 0;
    public const STATUS_ACCEPTED = 1;
    public const STATUS_CANCELED = 2;

    public const REQUEST_STATUS = [
        self::STATUS_PENDING,
        self::STATUS_ACCEPTED,
        self::STATUS_CANCELED,
    ];

    public const TYPE_BY_NUMBER_FILE = 0;
    public const TYPE_BY_TIME = 1;

    public const ROLE_USER = 0;
    public const ROLE_ADMIN = 1;

    public const STATUS_OK = 0;
    public const STATUS_ERROR = 1;

    public const UTC_HOUR = 7;

    public const DOWNLOAD_FILE = 'file';
    public const DOWNLOAD_VIDEO = 'video';
    public const DOWNLOAD_IMAGE = 'image';
    public const DOWNLOAD_LICENSE = 'license';
    public const DOWNLOAD_MUSIC = 'Music';
    public const DOWNLOAD_FINAL = 'Final';
    public const DOWNLOAD_AFTER = 'After';
    public const DOWNLOAD_PREMIERE = 'Premiere';
    public const DOWNLOAD_DAVINCI = 'Davinci';

    public const DOWNLOAD_TYPE = [
        self::DOWNLOAD_FILE,
        self::DOWNLOAD_VIDEO,
        self::DOWNLOAD_LICENSE,
        self::DOWNLOAD_IMAGE,
        self::DOWNLOAD_FINAL,
        self::DOWNLOAD_AFTER,
        self::DOWNLOAD_PREMIERE,
        self::DOWNLOAD_DAVINCI,
        self::DOWNLOAD_MUSIC,
    ];

    public const WEB_FREEPIK = 'Freepik';
    public const WEB_ENVATO = 'Envato';
    public const WEB_MOTION = 'Motionarray';
    public const WEB_LOVEPIK = 'Lovepik';
    public const WEB_PNGTREE = 'Pngtree';
    public const WEB_FLATICON = 'Flaticon';
    public const WEB_PIKBEST = 'Pikbest';
    public const WEB_STORYBLOCKS = 'Storyblocks';
    public const WEB_VECTEEZY = 'Vecteezy';
    public const WEB_CREATIVEFABRICA = 'Creativefabrica';
    public const WEB_YAYIMAGE = 'Yayimage';
    public const WEB_SLIDESGO = 'Slidesgo';
    public const WEB_ARTLIST = 'Artlist';
    public const WEB_ADOBE = 'Adobestock';
    public const WEB_ICONSCOUT = 'Iconscout';
    public const WEB_ALL = 'ALL';

    public const WEB_TYPE = [
        self::WEB_FREEPIK,
        self::WEB_ENVATO,
        self::WEB_MOTION,
        self::WEB_LOVEPIK,
        self::WEB_PNGTREE,
        self::WEB_FLATICON,
        self::WEB_PIKBEST,
        self::WEB_STORYBLOCKS,
        self::WEB_VECTEEZY,
        self::WEB_CREATIVEFABRICA,
        self::WEB_YAYIMAGE,
        self::WEB_SLIDESGO,
        self::WEB_ARTLIST,
        self::WEB_ADOBE,
        self::WEB_ICONSCOUT,
        self::WEB_ALL,
    ];

    public const WEB_REQUIRED_TYPE_DOWNLOAD = [
        self::WEB_FREEPIK,
        self::WEB_ENVATO,
        self::WEB_MOTION,
        self::WEB_LOVEPIK,
    ];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const IS_DOWNLOAD_BY_RETAIL = 1;
    public const IS_NOT_DOWNLOAD_BY_RETAIL = 0;

    public const KEY_EMAIL_NOTIFICATION = 'email-receive-notification';
}
