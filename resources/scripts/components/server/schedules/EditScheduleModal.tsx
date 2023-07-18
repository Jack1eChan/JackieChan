import tw from 'twin.macro';
import asModal from '@/hoc/asModal';
import useFlash from '@/plugins/useFlash';
import { httpErrorToHuman } from '@/api/http';
import { ServerContext } from '@/state/server';
import Field from '@/components/elements/Field';
import ModalContext from '@/context/ModalContext';
import Switch from '@/components/elements/Switch';
import { Form, Formik, FormikHelpers } from 'formik';
import { Button } from '@/components/elements/button/index';
import FormikSwitch from '@/components/elements/FormikSwitch';
import React, { useContext, useEffect, useState } from 'react';
import FlashMessageRender from '@/components/FlashMessageRender';
import { Schedule } from '@/api/server/schedules/getServerSchedules';
import createOrUpdateSchedule from '@/api/server/schedules/createOrUpdateSchedule';
import ScheduleCheatsheetCards from '@/components/server/schedules/ScheduleCheatsheetCards';

interface Props {
    schedule?: Schedule;
}

interface Values {
    name: string;
    dayOfWeek: string;
    month: string;
    dayOfMonth: string;
    hour: string;
    minute: string;
    enabled: boolean;
    onlyWhenOnline: boolean;
}

const EditScheduleModal = ({ schedule }: Props) => {
    const { addError, clearFlashes } = useFlash();
    const { dismiss } = useContext(ModalContext);

    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const appendSchedule = ServerContext.useStoreActions((actions) => actions.schedules.appendSchedule);
    const [showCheatsheet, setShowCheetsheet] = useState(false);

    useEffect(() => {
        return () => {
            clearFlashes('schedule:edit');
        };
    }, []);

    const submit = (values: Values, { setSubmitting }: FormikHelpers<Values>) => {
        clearFlashes('schedule:edit');
        createOrUpdateSchedule(uuid, {
            id: schedule?.id,
            name: values.name,
            cron: {
                minute: values.minute,
                hour: values.hour,
                dayOfWeek: values.dayOfWeek,
                month: values.month,
                dayOfMonth: values.dayOfMonth,
            },
            onlyWhenOnline: values.onlyWhenOnline,
            isActive: values.enabled,
        })
            .then((schedule) => {
                setSubmitting(false);
                appendSchedule(schedule);
                dismiss();
            })
            .catch((error) => {
                console.error(error);

                setSubmitting(false);
                addError({ key: 'schedule:edit', message: httpErrorToHuman(error) });
            });
    };

    return (
        <Formik
            onSubmit={submit}
            initialValues={
                {
                    name: schedule?.name || '',
                    minute: schedule?.cron.minute || '*/5',
                    hour: schedule?.cron.hour || '*',
                    dayOfMonth: schedule?.cron.dayOfMonth || '*',
                    month: schedule?.cron.month || '*',
                    dayOfWeek: schedule?.cron.dayOfWeek || '*',
                    enabled: schedule?.isActive ?? true,
                    onlyWhenOnline: schedule?.onlyWhenOnline ?? true,
                } as Values
            }
        >
            {({ isSubmitting }) => (
                <Form>
                    <h3 css={tw`text-2xl mb-6`}>{schedule ? '修改计划任务' : '创建计划任务'}</h3>
                    <FlashMessageRender byKey={'schedule:edit'} css={tw`mb-6`} />
                    <Field
                        name={'name'}
                        label={'计划名称'}
                        description={'为此计划任务设置一个可读性强的标识符。'}
                    />
                    <div css={tw`grid grid-cols-2 sm:grid-cols-5 gap-4 mt-6`}>
                        <Field name={'minute'} label={'Minute'} />
                        <Field name={'hour'} label={'Hour'} />
                        <Field name={'dayOfMonth'} label={'Day of month'} />
                        <Field name={'month'} label={'Month'} />
                        <Field name={'dayOfWeek'} label={'Day of week'} />
                    </div>
                    <p css={tw`text-neutral-400 text-xs mt-2`}>
                        计划系统支持使用 Cronjob 语法来定义任务何时开始运行。请使用上面的字段指定这些任务应该何时开始运行。
                    </p>
                    <div css={tw`mt-6 bg-neutral-900 border border-neutral-800 shadow-inner p-4 rounded`}>
                        <Switch
                            name={'show_cheatsheet'}
                            description={'显示一些计划任务的示例。'}
                            label={'显示示例'}
                            defaultChecked={showCheatsheet}
                            onChange={() => setShowCheetsheet((s) => !s)}
                        />
                        {showCheatsheet && (
                            <div css={tw`block md:flex w-full`}>
                                <ScheduleCheatsheetCards />
                            </div>
                        )}
                    </div>
                    <div css={tw`mt-6 bg-neutral-900 border border-neutral-800 shadow-inner p-4 rounded`}>
                        <FormikSwitch
                            name={'onlyWhenOnline'}
                            description={'只有当服务器处于运行状态时才执行此计划。'}
                            label={'只有当服务器在线时才执行任务'}
                        />
                    </div>
                    <div css={tw`mt-6 bg-neutral-900 border border-neutral-800 shadow-inner p-4 rounded`}>
                        <FormikSwitch
                            name={'enabled'}
                            description={'如果启用了此计划，它将自动执行。'}
                            label={'Schedule 状态'}
                        />
                    </div>
                    <div css={tw`mt-6 text-right`}>
                        <Button className={'w-full sm:w-auto'} type={'submit'} disabled={isSubmitting}>
                            {schedule ? '保存修改' : '创建计划'}
                        </Button>
                    </div>
                </Form>
            )}
        </Formik>
    );
};

export default asModal<Props>()(EditScheduleModal);
