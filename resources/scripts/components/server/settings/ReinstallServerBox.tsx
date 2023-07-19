import tw from 'twin.macro';
import { ApplicationStore } from '@/state';
import { httpErrorToHuman } from '@/api/http';
import { ServerContext } from '@/state/server';
import React, { useEffect, useState } from 'react';
import { Actions, useStoreActions } from 'easy-peasy';
import { Dialog } from '@/components/elements/dialog';
import reinstallServer from '@/api/server/reinstallServer';
import { Button } from '@/components/elements/button/index';
import TitledGreyBox from '@/components/elements/TitledGreyBox';

export default () => {
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const [modalVisible, setModalVisible] = useState(false);
    const { addFlash, clearFlashes } = useStoreActions((actions: Actions<ApplicationStore>) => actions.flashes);

    const reinstall = () => {
        clearFlashes('settings');
        reinstallServer(uuid)
            .then(() => {
                addFlash({
                    key: 'settings',
                    type: 'success',
                    message: '您的服务器已开始重新安装。',
                });
            })
            .catch((error) => {
                console.error(error);

                addFlash({ key: 'settings', type: 'danger', message: httpErrorToHuman(error) });
            })
            .then(() => setModalVisible(false));
    };

    useEffect(() => {
        clearFlashes();
    }, []);

    return (
        <TitledGreyBox title={'重新安装服务器'} css={tw`relative`}>
            <Dialog.Confirm
                open={modalVisible}
                title={'确认重新安装服务器'}
                confirm={'重新安装服务器'}
                onClose={() => setModalVisible(false)}
                onConfirmed={reinstall}
            >
                您的服务器将被停止，并且在此过程中可能会删除或修改一些文件，您确定要继续吗?
            </Dialog.Confirm>
            <p css={tw`text-sm`}>
                重新安装服务器将停止服务器，并重新运行最初设置服务器的安装脚本。&nbsp;
                <strong css={tw`font-medium`}>
                    在继续之前，请备份您的数据，因为在此过程中可能会删除或修改一些文件。
                </strong>
            </p>
            <div css={tw`mt-6 text-right`}>
                <Button.Danger variant={Button.Variants.Secondary} onClick={() => setModalVisible(true)}>
                    重新安装服务器
                </Button.Danger>
            </div>
        </TitledGreyBox>
    );
};
