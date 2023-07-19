import tw from 'twin.macro';
import isEqual from 'react-fast-compare';
import Can from '@/components/elements/Can';
import { ServerContext } from '@/state/server';
import { useFlashKey } from '@/plugins/useFlash';
import React, { useEffect, useState } from 'react';
import Spinner from '@/components/elements/Spinner';
import { Button } from '@/components/elements/button/index';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import getServerAllocations from '@/api/swr/getServerAllocations';
import AllocationRow from '@/components/server/network/AllocationRow';
import { useDeepCompareEffect } from '@/plugins/useDeepCompareEffect';
import ServerContentBlock from '@/components/elements/ServerContentBlock';
import createServerAllocation from '@/api/server/network/createServerAllocation';

const NetworkContainer = () => {
    const [loading, setLoading] = useState(false);
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const allocationLimit = ServerContext.useStoreState((state) => state.server.data!.featureLimits.allocations);
    const allocations = ServerContext.useStoreState((state) => state.server.data!.allocations, isEqual);
    const setServerFromState = ServerContext.useStoreActions((actions) => actions.server.setServerFromState);

    const { clearFlashes, clearAndAddHttpError } = useFlashKey('server:network');
    const { data, error, mutate } = getServerAllocations();

    useEffect(() => {
        mutate(allocations);
    }, []);

    useEffect(() => {
        clearAndAddHttpError(error);
    }, [error]);

    useDeepCompareEffect(() => {
        if (!data) return;

        setServerFromState((state) => ({ ...state, allocations: data }));
    }, [data]);

    const onCreateAllocation = () => {
        clearFlashes();

        setLoading(true);
        createServerAllocation(uuid)
            .then((allocation) => {
                setServerFromState((s) => ({ ...s, allocations: s.allocations.concat(allocation) }));
                return mutate(data?.concat(allocation), false);
            })
            .catch((error) => clearAndAddHttpError(error))
            .then(() => setLoading(false));
    };

    return (
        <ServerContentBlock
            title={'网络'}
            description={'配置外部网络和端口。'}
            showFlashKey={'server:network'}
        >
            {!data ? (
                <Spinner size={'large'} centered />
            ) : (
                <>
                    {data.map((allocation) => (
                        <AllocationRow key={`${allocation.ip}:${allocation.port}`} allocation={allocation} />
                    ))}
                    {allocationLimit > 0 && (
                        <Can action={'allocation.create'}>
                            <SpinnerOverlay visible={loading} />
                            <div css={tw`mt-6 sm:flex items-center justify-end`}>
                                <p css={tw`text-sm text-neutral-300 mb-4 sm:mr-6 sm:mb-0`}>
                                    您当前使用了 {data.length} 个端口，服务器总共允许使用 {allocationLimit} 个端口。
                                </p>
                                {allocationLimit > data.length && (
                                    <Button css={tw`w-full sm:w-auto`} onClick={onCreateAllocation}>
                                        新增端口
                                    </Button>
                                )}
                            </div>
                        </Can>
                    )}
                </>
            )}
        </ServerContentBlock>
    );
};

export default NetworkContainer;
