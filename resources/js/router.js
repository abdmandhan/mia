import Vue from 'vue';
import VueRouter from 'vue-router';

import NotFound from './components/NotFoundComponent';
import Dashboard from './components/dashboard/DashboardComponent';
import Layout from './components/LayoutComponent';
import Login from './components/auth/LoginComponent';
import Register from './components/auth/RegisterComponent';

import Course from './components/course/CourseComponent';
import CourseCreate from './components/course/CourseCreateComponent';
import CourseEdit from './components/course/CourseEditComponent';

import CourseTeacherCreate from './components/course/course-teacher/CourseTeacherCreateComponent';

import CourseContentCreate from './components/course/course-content/CourseContentCreateComponent';
import CourseContentEdit from './components/course/course-content/CourseContentEditComponent';

import CourseTaskCreate from './components/course/course-task/CourseTaskCreateComponent';
import CourseTaskEdit from './components/course/course-task/CourseTaskEditComponent';

import CourseTaskQuestionCreate from './components/course/course-task/course-task-question/CourseTaskQuestionCreateComponent';
import CourseTaskQuestionEdit from './components/course/course-task/course-task-question/CourseTaskQuestionEditComponent';



Vue.use(VueRouter);

const router = new VueRouter({
    base: '/v/',
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
            component: Layout,
            children: [
                {
                    path: "/dashboard",
                    name: "dashboard",
                    component: Dashboard
                },

                //Course
                {
                    path: "/course-management",
                    name: "course-management",
                    component: Course
                },
                {
                    path: "/course-management/create",
                    name: "course-management.create",
                    component: CourseCreate
                },
                {
                    path: "/course-management/:course_id/edit",
                    name: "course-management.edit",
                    component: CourseEdit
                },

                //Course Task
                {
                    path: "/course-task-management/:course_id/create",
                    name: "course-task-management.create",
                    component: CourseTaskCreate
                },
                {
                    path: "/course-task-management/:course_task_id/edit",
                    name: "course-task-management.edit",
                    component: CourseTaskEdit
                },

                //Course Task Question
                {
                    path: "/course-task-question-management/:course_task_id/create",
                    name: "course-task-question-management.create",
                    component: CourseTaskQuestionCreate
                },
                {
                    path: "/course-task-question-management/:course_task_question_id/edit",
                    name: "course-task-question-management.edit",
                    component: CourseTaskQuestionEdit
                },


                //Course Task
                {
                    path: "/course-content-management/:course_id/create",
                    name: "course-content-management.create",
                    component: CourseContentCreate
                },
                {
                    path: "/course-content-management/:course_content_id/edit",
                    name: "course-content-management.edit",
                    component: CourseContentEdit
                },

                //Course Teacher
                {
                    path: "/course-teacher-management/:course_id/create",
                    name: "course-teacher-management.create",
                    component: CourseTeacherCreate
                },

            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/*',
            redirect: { name: '404' }
        },
        {
            path: '/404',
            name: '404',
            component: NotFound
        },

    ]
})

export default router;