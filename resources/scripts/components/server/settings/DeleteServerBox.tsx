import React, { useState } from 'react';
import useFlash from '@/plugins/useFlash';
import Code from '@/components/elements/Code';
import { ServerContext } from '@/state/server';
import Input from '@/components/elements/Input';
import deleteServer from '@/api/server/deleteServer';
import { Dialog } from '@/components/elements/dialog';
import { Button } from '@/components/elements/button/index';
import TitledGreyBox from '@/components/elements/TitledGreyBox';

export default () => {
    const [name, setName] = useState('');
    const [warn, setWarn] = useState(false);
    const [confirm, setConfirm] = useState(false);

    const { addFlash, clearFlashes, clearAndAddHttpError } = useFlash();

    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const serverName = ServerContext.useStoreState((state) => state.server.data!.name);

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        e.stopPropagation();
        clearFlashes('settings');

        deleteServer(uuid, name)
            .then(() => {
                setConfirm(false);
                addFlash({
                    key: 'settings',
                    type: 'success',
                    message: '您的服务器已删除。',
                });
                // @ts-expect-error this is valid
                window.location = '/';
            })
            .catch((error) => clearAndAddHttpError({ key: 'settings', error }));
    };

    return (
        <TitledGreyBox title={'删除服务器'} className={'relative mb-12'}>
            <Dialog.Confirm
                open={warn}
                title={'确认删除服务器'}
                confirm={'删除服务器'}
                onClose={() => setWarn(false)}
                onConfirmed={() => {
                    setConfirm(true);
                    setWarn(false);
                }}
            >
                您的服务器将被删除，所有文件将被清除，并且服务器的资源将归还到您的账户。您确定要继续吗？
            </Dialog.Confirm>
            <form id={'delete-server-form'} onSubmit={submit}>
                <Dialog
                    open={confirm}
                    title={'Confirm server deletion'}
                    onClose={() => {
                        setConfirm(false);
                        setName('');
                    }}
                >
                    {name !== serverName && (
                        <>
                            <p className={'my-2 text-gray-400'}>
                                在下面输入 <Code>{serverName}</Code> 。
                            </p>
                            <Input type={'text'} value={name} onChange={(n) => setName(n.target.value)} />
                        </>
                    )}
                    <Button
                        disabled={name !== serverName}
                        type={'submit'}
                        className={'mt-2'}
                        form={'delete-server-form'}
                    >
                        删除服务器
                    </Button>
                </Dialog>
            </form>
            <p className={'text-sm'}>
                删除服务器将关闭所有进程，将资源归还到您的账户，并删除与实例相关的所有文件，包括备份、数据库和设置。{' '}
                <strong className={'font-medium'}>
                    如果继续执行此操作，所有数据将永久丢失。
                </strong>
            </p>
            <div className={'mt-6 font-medium text-right'}>
                <Button.Danger variant={Button.Variants.Secondary} onClick={() => setWarn(true)}>
                    删除服务器
                </Button.Danger>
            </div>
        </TitledGreyBox>
    );
};
