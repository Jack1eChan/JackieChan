import useFlash from '@/plugins/useFlash';
import apiVerify from '@/api/account/verify';
import { useStoreState } from '@/state/hooks';
import React, { useEffect, useState } from 'react';
import { formatDistanceToNowStrict } from 'date-fns';
import { getResources } from '@/api/store/getResources';
import Translate from '@/components/elements/Translate';
import InformationBox from '@/components/elements/InformationBox';
import getLatestActivity, { Activity } from '@/api/account/getLatestActivity';
import { wrapProperties } from '@/components/elements/activity/ActivityLogEntry';
import {
    faCircle,
    faCoins,
    faExclamationCircle,
    faScroll,
    faTimesCircle,
    faUserLock,
} from '@fortawesome/free-solid-svg-icons';

export default () => {
    const { addFlash } = useFlash();
    const [bal, setBal] = useState(0);
    const [activity, setActivity] = useState<Activity>();
    const properties = wrapProperties(activity?.properties);
    const user = useStoreState((state) => state.user.data!);
    const store = useStoreState((state) => state.storefront.data!);

    useEffect(() => {
        getResources().then((d) => setBal(d.balance));
        getLatestActivity().then((d) => setActivity(d));
    }, []);

    const verify = () => {
        apiVerify().then((data) => {
            if (data.success)
                addFlash({ type: 'info', key: 'dashboard', message: '已重新发送验证邮件。' });
        });
    };

    return (
        <>
            {store.earn.enabled ? (
                <InformationBox icon={faCircle} iconCss={'animate-pulse'}>
                    每在线1分钟获得 <span className={'text-green-600'}>{store.earn.amount}</span> 积分。
                </InformationBox>
            ) : (
                <InformationBox icon={faExclamationCircle}>
                    在线赚积分功能 <span className={'text-red-600'}>未开启</span>。
                </InformationBox>
            )}
            <InformationBox icon={faCoins}>
                您当前拥有 <span className={'text-green-600'}>{bal}</span> 积分。
            </InformationBox>
            <InformationBox icon={faUserLock}>
                {user.useTotp ? (
                    <>
                        您的账户已开启<span className={'text-green-600'}>双因素身份验证</span> 。
                    </>
                ) : (
                    <>
                        您的账户未开启<span className={'text-yellow-600'}>双因素身份验证</span> 。
                    </>
                )}
            </InformationBox>
            {!user.verified ? (
                <InformationBox icon={faTimesCircle} iconCss={'text-yellow-500'}>
                    <span onClick={verify} className={'cursor-pointer text-blue-400'}>
                        请先完成账户验证以开始使用。
                    </span>
                </InformationBox>
            ) : (
                <InformationBox icon={faScroll}>
                    {activity ? (
                        <>
                            <span className={'text-neutral-400'}>
                                <Translate
                                    ns={'activity'}
                                    values={properties}
                                    i18nKey={activity.event.replace(':', '.')}
                                />
                            </span>
                            {' - '}
                            {formatDistanceToNowStrict(activity.timestamp, { addSuffix: true })}
                        </>
                    ) : (
                        '无法获取最新的事件日志。'
                    )}
                </InformationBox>
            )}
        </>
    );
};
